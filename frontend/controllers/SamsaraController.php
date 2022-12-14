<?php

namespace frontend\controllers;

use common\helpers\DateTime;
use common\models\Load;
use yii\helpers\ArrayHelper;
use Yii;
use frontend\forms\samsara\TimeSelect;

class SamsaraController extends \yii\web\Controller
{
    protected $samsara;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->samsara = \Yii::$app->samsara;
    }

    public function actionTrucksOnMap()
    {
        $startTimeData = [
            '1 hour' => '1 hour',
            '3 hours' => '3 hours',
            '6 hours' => '6 hours',
            '12 hours' => '12 hours',
            '1 day' => '1 day',
            '3 days' => '3 days',
            '5 days' => '5 days',
            '7 days' => '7 days',
        ];
        $endTimeData = 'now';
        $form = new TimeSelect();
        $form->startTime = $startTimeData['3 hours'];
        $form->endTime = $endTimeData;

        if (Yii::$app->request->isPost) {
            $form->load(Yii::$app->request->post());
            if (!$form->validate()) {
                throw new BadRequestHttpException('Bad request');
            }
        }
        $requestData = $this->requestData($form->startTime,$form->endTime);
        $loadModel = Load::findOne($load);
        return $this->render('trucks-on-map', [
            'cacheStatus'=>$requestData['cacheStatus'],
            'data' => $requestData['trucksData'],
            'model' => $loadModel,
            'form' => $form,
            'currentValues' => [
                $form->startTime,
                $form->endTime
            ],
            'startTimeData' => $startTimeData,
            'endTimeData' => $endTimeData,
        ]);
    }

    public function actionTruckInfo($name,$startTime,$endTime) {
        $requestData = $this->requestData($startTime,$endTime);
        return $this->renderAjax('truck-info',[
            'data' => isset($requestData['trucksData'][$name]) ? $requestData['trucksData'][$name] : false,
            'cacheStatus'=>$requestData['cacheStatus'],
        ]);
    }

    private function requestData($startTime,$endTime) {
        $trucksData = [];
        $cacheStatus = '';
        $cache = Yii::$app->cache;
        //$cache->flush(); die;
        $cacheKey = str_replace(" ","_",$startTime.$endTime);
        $trucksData = $cache->get($cacheKey);
        if($trucksData === false) {
            $fields = [
                'gps', 'gpsDistanceMeters', 'gpsOdometerMeters',
                'engineStates', 'engineLoadPercent', 'ecuSpeedMph',
                'defLevelMilliPercent', 'fuelPercents', 'batteryMilliVolts',
                'obdOdometerMeters', 'faultCodes', 'ambientAirTemperatureMilliC',
            ];

            $chunkedFields = array_chunk($fields, 3);
            $start = new \DateTime('now');
            $start = $start->sub(\DateInterval::createFromDateString($startTime));
            $startTimeCalc = $start->format('Y-m-d\TH:i:s\Z');
            $end = new \DateTime($endTime);
            $endTimeCalc = $end->format('Y-m-d\TH:i:s\Z');

            $cacheStatus = 'Not from cache, data requested';
            foreach ($chunkedFields as $chunk) {
                $fields =  implode(",", $chunk);
                $res = $this->samsara->request('GET',"/fleet/vehicles/stats/history?types=$fields&startTime=$startTimeCalc&endTime=$endTimeCalc");
                $data = $this->array_remove_empty($res->getData());
                if($data['data'] && is_array($data['data'] )) {
                    foreach ($data['data'] as $item) {
                        $trucksData[$item['name']] = ArrayHelper::merge($trucksData[$item['name']], $item);
                    }
                }
            }
            $cache->set($cacheKey,$trucksData,600); // 10 min in cache
        } else {
            $cacheStatus = 'Data from cache';
        }
        return ['cacheStatus' => $cacheStatus, 'trucksData'=> $trucksData];
    }

    private function array_remove_empty($haystack)
    {
        if(!is_array($haystack)) {
            return $haystack;
        }
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $haystack[$key] = $this->array_remove_empty($haystack[$key]);
            }

            if (empty($haystack[$key])) {
                unset($haystack[$key]);
            }
        }

        return $haystack;
        $trucks = $this->samsara->request('GET', '/fleet/vehicles/stats/feed?types=gps&decorations=obdEngineSeconds,fuelPercents');
        $data = $trucks->getData();

        $list = $this->samsara->request('GET', '/fleet/vehicles/stats?types=gps');
        $listData = $list->getData();

        $history = $this->samsara->request('GET','https://api.samsara.com/fleet/vehicles/stats/history?types=gps&startTime=2021-10-01T00:00:00Z&endTime=2021-12-01T00:00:00Z');
        $historyData = $history->getData();


        return $this->render('trucks-on-map', [
            'data' => $data,
            'listData' => $this->array_remove_empty($listData),
            'historyData' => $this->array_remove_empty($historyData)
        ]);
    }

    public function actionTrucksInMap() {
        $trucks = $this->samsara->request('GET', '/fleet/vehicles/stats/feed?types=gps&decorations=obdEngineSeconds,fuelPercents');
        $data = $trucks->getData();

        return $this->render('trucks-in-map', [
            'data' => $data,
        ]);
    }

    public function actionTruckDetail($id) {
        return $this->render('truck-detail', [
            'id' => $id,
        ]);
    }
//
//    private function array_remove_empty($haystack)
//    {
//        foreach ($haystack as $key => $value) {
//            if (is_array($value)) {
//                $haystack[$key] = $this->array_remove_empty($haystack[$key]);
//            }
//
//            if (empty($haystack[$key])) {
//                unset($haystack[$key]);
//            }
//        }
//
//        return $haystack;
//    }

    public function actionClearCache($startCache = false,$endCache = false) {
        if($startCache && $endCache) {
            if(Yii::$app->cache->delete(str_replace(" ","_",$startCache.$endCache))) {
                return true;
            } else {
                return false;
            }
        } else {
            $startTimeData = [
                '1 hour' => '1 hour',
                '3 hours' => '3 hours',
                '6 hours' => '6 hours',
                '12 hours' => '12 hours',
                '1 day' => '1 day',
                '3 days' => '3 days',
                '5 days' => '5 days',
                '7 days' => '7 days',
            ];
            $endTimeData = 'now';
            $cacheCount = 0;
            foreach ($startTimeData as $k => $v) {
                    if(Yii::$app->cache->delete(str_replace(" ", "_", $v . $endTimeData))) {
                        $cacheCount++;
                    }
            }
            if($cacheCount > 0) {
                return true;
            }
            return false;
        }
    }

    private function cUrlGetData($url) {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Authorization: Bearer '.\Yii::$app->samsara->apiKey,
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $body = '{}';
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $requestData = curl_exec($ch);
        curl_close($ch);
        if($requestData) {
            return ArrayHelper::toArray(json_decode($requestData));
        }
        return false;
    }

    public function actionDrivers() {
            $cache = Yii::$app->cache;
            $activeDrivers = $cache->get('activeDrivers');
            if ($activeDrivers === false) {
                $activeDrivers = $this->cUrlGetData('https://api.samsara.com/fleet/drivers?driverActivationStatus=active');
                $cache->set('activeDrivers', $activeDrivers, 600); // 10 min
            }
            $deactiveDrivers = $cache->get('deactiveDrivers');
            if ($deactiveDrivers === false) {
                $deactiveDrivers = $this->cUrlGetData('https://api.samsara.com/fleet/drivers?driverActivationStatus=deactivated');
                $cache->set('deactiveDrivers', $deactiveDrivers, 600); // 10 min
            }
            $allDriversList = [];
            foreach($activeDrivers['data'] as $k=>$v) {
                array_push($allDriversList,$v);
            }
            foreach($deactiveDrivers['data'] as $k=>$v) {
                array_push($allDriversList,$v);
            }
            $allDriversHos = $cache->get('allDriversHos');
            if ($allDriversHos === false) {
                $allDriversHos = $this->cUrlGetData('https://api.samsara.com/fleet/hos/clocks');
                $cache->set('allDriversHos', $allDriversHos, 600); // 10 min
            }
            foreach($allDriversList as $k=>$v) {
                foreach($allDriversHos['data'] as $kh=>$vh) {
                    if($v['id'] == $vh['driver']['id']) {
                        $allDriversList[$k]['currentDutyStatus'] = $vh['currentDutyStatus'];
                        $allDriversList[$k]['currentVehicle'] = $vh['currentVehicle'];
                    }
                }
            }
            return $this->render('drivers', [
                'allDriversList' => $allDriversList,
            ]);
    }

    public function actionDriver($id) {
        $cache = Yii::$app->cache;
        //$cache->flush();
        $driverInfoClock = $cache->get('driverInfoClock_'.$id);
        if($driverInfoClock === false) {
            $driverInfoClock = $this->cUrlGetData('https://api.samsara.com/fleet/hos/clocks?tagIds=&driverIds='.$id);
            $cache->set('driverInfoClock_'.$id,$driverInfoClock,600);
        }
        $driverInfoLog = $cache->get('driverInfoLog_'.$id);

        $start = new \DateTime('today midnight');
        $startTimeCalc = $start->format('Y-m-d\TH:i:s\Z');
        $end = new \DateTime('now');
        $endTimeCalc = $end->format('Y-m-d\TH:i:s\Z');

        if($driverInfoLog === false) {
            $driverInfoLog = $this->cUrlGetData('https://api.samsara.com/fleet/hos/logs?tagIds=&driverIds='.$id.'&startTime='.$startTimeCalc.'&endTime='.$endTimeCalc);
            $cache->set('driverInfoLog_'.$id,$driverInfoLog,600);
        }

        return $this->render('driver', [
            'driverInfoLog' => $driverInfoLog['data'][0],
            'driverInfoClock' => $driverInfoClock['data'],
        ]);
    }

    public function actionDriverLog($id) {
        $cache = Yii::$app->cache;
        $driverInfoClockDetail = $cache->get('driverInfoClockDetail_'.$id);
        if($driverInfoClockDetail === false) {
            $driverInfoClockDetail = $this->cUrlGetData('https://api.samsara.com/fleet/hos/clocks?tagIds=&driverIds='.$id);
            $cache->set('driverInfoClockDetail_'.$id,$driverInfoClockDetail,600);
        }

        $start = new \DateTime('today midnight');
        $startTimeCalc = $start->format('Y-m-d\TH:i:s\Z');

        $end = new \DateTime('now');
        $endTimeCalc = $end->format('Y-m-d\TH:i:s\Z');
        $driverInfoLog = $cache->get('driverInfoLog_'.$id);
        if($driverInfoLog === false) {
            $driverInfoLog = $this->cUrlGetData('https://api.samsara.com/fleet/hos/logs?tagIds=&driverIds='.$id.'&startTime='.$startTimeCalc.'&endTime='.$endTimeCalc);
            $cache->set('driverInfoLog_'.$id,$driverInfoLog,600);
        }

        $startTimeCalcFormat = $start->format('Y-m-d');
        $endTimeCalcFormat = $end->format('Y-m-d');
        $allHosLogsDaily = $cache->get('allHosLogsDailyCache_'.$id);
        if($allHosLogsDaily === false) {
            $allHosLogsDaily = $this->cUrlGetData('https://api.samsara.com/fleet/hos/daily-logs?driverIds='.$id.'&startDate='.$startTimeCalcFormat.'&endDate='.$endTimeCalcFormat);
            $cache->set('allHosLogsDailyCache_'.$id,$allHosLogsDaily,600); // 10 min
        }

        return $this->render('driver-log', [
            'driverInfoLog' => $driverInfoLog['data'][0],
            'driverInfoClockDetail' => $driverInfoClockDetail['data'][0],
            'allHosLogsDaily' => $allHosLogsDaily['data'],
        ]);
    }
}