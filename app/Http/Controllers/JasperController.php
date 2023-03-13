<?php

namespace App\Http\Controllers;

use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentNewVehicle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

use PHPJasper\PHPJasper;

class JasperController extends Controller
{

    public function jasperReport(Request $request)
    {

        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
        if (ob_get_contents()) {ob_end_clean();}

        $carbon = new Carbon();
        $carbon->setLocale('ms');

        $title = $request->title;
        $reportName = $request->report_name;

        $params = [];

        require __DIR__.'/JasperModuleVehicle.php';

        require __DIR__.'/JasperModuleAssessment.php';

        require __DIR__.'/JasperModuleMaintenance.php';

        require __DIR__.'/JasperModuleSummon.php';

        Log::info($params);

        $input = app_path().'/jasper/'.$reportName.'.jasper';

        $filename = $reportName.'-'.date('d-m-y-h:m:s');
        $output = public_path().'/jasper/'.$filename;
        $format = $request->format;

        $titleWithFormat = $title.'.'.$format;
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$titleWithFormat.'"'
        ];

        $options = [
            'format' => [$format],
            'fonts' => __DIR__.'public/fonts',
            'locale' => 'en',
            'params' => $params,
            'db_connection' => [
                'driver' => 'postgres',
                'username' => env('DB_USERNAME'),
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'port' => env('DB_PORT')
            ]
        ];

        if(!empty(env('DB_PASSWORD'))){
            $options['db_connection']['password'] = env('DB_PASSWORD');
        }

        if(env('APP_ENV') == 'production'){
            $jasper = new PHPJasper;
        }

        if(!file_exists($input)) {
            $input = app_path().'/jasper/'.$reportName.'.jrxml';
            $jasper->compile($input)->execute();
            $jasper->process(
                $input,
                $output,
                $options
            )->execute();
        } else {
            $jasper->process(
                $input,
                $output,
                $options
            )->execute();
        }

        return response()->file($output.'.'.$format, $headers)->deleteFileAfterSend(true);

    }

    public function jasperReportAPI(Request $request)
    {

        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
        if (ob_get_contents()) {ob_end_clean();}

        if(env('APP_ENV') == 'local'){
            $jasper = new PHPJasper;
        }

        $title = $request->title;
        $reportName = $request->report_name;

        $params = [];

        require __DIR__.'/JasperModuleVehicle.php';

        require __DIR__.'/JasperModuleAssessment.php';

        require __DIR__.'/JasperModuleMaintenance.php';

        require __DIR__.'/JasperModuleSummon.php';

        Log::info($params);

        $input = app_path().'/jasper/'.$reportName.'.jasper';

        $filename = $reportName.'-'.date('d-m-y-h:m:s');
        $output = public_path().'/jasper/'.$filename;
        $format = $request->format;

        $titleWithFormat = $title.'.'.$format;
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$titleWithFormat.'"'
        ];

        $options = [
            'format' => [$format],
            'fonts' => __DIR__.'public/fonts',
            'locale' => 'en',
            'params' => $params,
            'db_connection' => [
                'driver' => 'postgres',
                'username' => env('DB_USERNAME'),
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'port' => env('DB_PORT')
            ]
        ];

        if(!empty(env('DB_PASSWORD'))){
            $options['db_connection']['password'] = env('DB_PASSWORD');
        }

        Log::info($options);

        if(!file_exists($input)) {
            $input = app_path().'/jasper/'.$reportName.'.jrxml';
            $jasper->compile($input)->execute();
        }

        $reportType = $request->report_type;
        $title = $request->title;
        $format = 'pdf';

        $filePath = app_path().'/jasper/'.$reportName.'.jasper';

        $endpoint = "http://localhost:8081/jasperserver/";
        $client = new \GuzzleHttp\Client();

        $params['isStaging'] = 0;
        $params['auth'] = ['jasperadmin', 'jasperadmin'];
        $params['report_type'] = $reportType;
        $params['fullPath'] = $filePath;
        $params['driver_name'] = env('DB_CONNECTION');
        $params['host'] = 'jdbc:postgresql://'.env('DB_HOST').':'.env('DB_PORT').'/'.env('DB_DATABASE');
        $params['username'] = env('DB_USERNAME');
        $params['password'] = env('DB_PASSWORD');

        switch ($reportType) {
            case 'pdf':
                $params['report_type'] = $reportType;
                $titleWithFormat = $title.'.pdf';
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$titleWithFormat.'"'
                ];
                break;
            case 'excel':
                $format  = 'xls';
                $titleWithFormat = $title.'.xls';
                $headers = [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="'.$titleWithFormat.'"'
                ];
                break;
            case 'word':
                $format  = 'docx';
                $titleWithFormat = $title.'.docx';
                $headers = [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'Content-Disposition' => 'attachment; filename="'.$titleWithFormat.'"'
                ];
                break;

            default:
            $format  = 'pdf';
                break;
        }

        $options = [
            'query' => $params
        ];
        echo '<pre>';
        print_r($options);
        echo '</pre>';
        die();
        $response = $client->request('POST', $endpoint, $options);

        $body = $response->getBody();


        $filename = $reportName.'-'.date('d-m-y-h:m:s');
        $output = public_path().'/jasper/'.$filename;

        Log::info($headers);

        Storage::disk('local')->put($output.'.'.$format, $body);
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        return response()->file($storagePath."/".$output.'.'.$format, $headers)->deleteFileAfterSend(true);

    }

    public function getDefaultDatabaseConfigPgSQL()
    {
        return [
            // 'driver' => 'postgres',
            // 'username' => 'postgres',
            // 'password' => '',
            // 'host' => '127.0.0.1',
            // 'database' => 'spakat',
            // 'port' => '5432'
            'driver' => 'postgres',
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'port' => env('DB_PORT'),
            // 'jdbc_driver' => 'org.postgresql.Driver',
            // 'jdbc_url' => 'jdbc:postgresql://127.0.0.1:5432/spakat',
            // 'jdbc_dir' => '/Users/cubixi/git/spakat/public/jasper/test'
        ];
    }

    public function DefaultPublicDirectory()
    {
        return public_path('jasper');
    }

    public function DefaultStorageDirectoty()
    {
        return storage_path('jasper');
    }

}
