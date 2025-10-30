<?php

namespace Database\Seeders;

use App\Http\traits\ENVFilePutContent;
use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class LandlordGeneralSettingSeeder extends Seeder
{
    use ENVFilePutContent;

    public function run(): void
    {
        GeneralSetting::truncate();

        $timeZone = "Asia/Dhaka";
        $dateFormat = "d-m-Y";

        $siteTitle = "AvantCoreTechnologies";

        $data = [
            'site_title' => $siteTitle,
            'site_logo'  => "202310100928261.png",
            'time_zone' => $timeZone,
            'phone' => '123456789',
            'email' => 'support@lion-coders.com',
            'free_trial_limit' => 5,
            'currency_code' => "USD",
            'frontend_layout' => "regular",
            'date_format' => $dateFormat,
            'footer' => "avantcoretech",
            'footer_link' => "https://avantcoretech.com",
            'developed_by' => 'avantcoretech',
        ];

        GeneralSetting::create($data);

        //writting timezone info in .env file
        $this->dataWriteInENVFile('APP_NAME',$siteTitle);
        $this->dataWriteInENVFile('APP_TIMEZONE',$timeZone);
        $this->dataWriteInENVFile('Date_Format',$dateFormat);
        $js_format = config('date_format_conversion.' . $dateFormat);
        $this->dataWriteInENVFile('Date_Format_JS',$js_format);
        // $this->dataWriteInENVFile('ENABLE_EARLY_CLOCKIN',1);
    }
}
