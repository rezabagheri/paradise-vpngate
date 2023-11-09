<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Server;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const VPNGATE_SERVER = 'http://www.vpngate.net/api/iphone/';
    const DELIMITER = '\x0D\x0A';
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        //get list of vpn from http://www.vpngate.net/api/iphone/

        try {
            $response = file_get_contents(self::VPNGATE_SERVER);

            if ($response === false) {
                echo "Failed to fetch data from the API";
                return;
            }

            //remove *vpn_servers from the begin of the response
            $csvData = explode("#", $response)[1];
            $csvData = str_replace('*', '', $csvData );
            //echo substr( $csvData, 0, 200 );
            //echo "\n";
            //echo bin2hex(substr( $csvData, 0, 200 ));
            //split string with delimiter \x0D\x0A
            //$lines = explode( '\x0d\x0a', $csvData );
            $lines = preg_split('/\r\n|\n/', $csvData);
            echo $lines[0];


            //csv line 0, containes data header
            $header = explode(",", $lines[0]);
            print_r($header);

            // Iterate through lines and convert to JSON
            //each line contains a server data(comma sepereted)
            for ($i = 1; $i < count($lines) - 1; $i++) {
                $lineData = explode(",", $lines[$i]);

                $jsonData = [];
                for ($j = 0; $j < count($header); $j++) {
                    if ($j >= count($lineData))
                        continue;
                    $jsonData[$header[$j]] = $lineData[$j];
                }

                //create Server opbject
                $server = new Server();
                try {
                    //if hostname or ip not set ignore it
                    if (!isset($jsonData['HostName']) || !isset($jsonData['IP'])) continue;

                    $ping = isset($jsonData['Ping'])
                        ? (is_numeric($jsonData['Ping']) ? $jsonData['Ping'] : -1)
                        : -1;

                    $speed = isset($jsonData['Speed'])
                        ? (is_numeric($jsonData['Speed']) ? $jsonData['Speed'] : -1)
                        : -1;

                    $server->host_name = $jsonData['HostName'];
                    $server->ip = isset($jsonData['IP']) ? $jsonData['IP'] : 'unknown';
                    $server->score = isset($jsonData['Score']) ? $jsonData['Score'] : 0;
                    $server->ping = $ping;
                    $server->speed = $speed;
                    $server->country_long = isset($jsonData['CountryLong']) ? $jsonData['CountryLong'] : 'unknown';
                    $server->country_short = isset($jsonData['CountryShort']) ? $jsonData['CountryShort'] : 'unknown';
                    $server->num_vpn_sessions = isset($jsonData['NumVpnSessions']) ? $jsonData['NumVpnSessions'] : -1;
                    $server->uptime = isset($jsonData['uptime']) ? $jsonData['uptime'] : 0;
                    $server->total_users = isset($jsonData['TotalUsers']) ? $jsonData['TotalUsers'] : 0;
                    $server->total_traffic = isset($jsonData['TotalTraffic']) ? $jsonData['TotalTraffic'] : 0;
                    $server->log_type = isset($jsonData['LogType']) ? $jsonData['LogType'] : "";
                    $server->operator = isset($jsonData['Operator']) ? $jsonData['Operator'] : "";
                    $server->message = isset($jsonData['Message']) ? $jsonData['Message'] : "";

                    $server->openvpn_config_data_base64 = isset($jsonData['OpenVPN_ConfigData_Base64'])
                        ? $jsonData['OpenVPN_ConfigData_Base64']
                        : 'unknown';

                    $server->save();
                } catch (Exception $e) {
                    echo "Error Occurred: " . $e->getMessage();
                }
            }
        } catch (Exception $e) {
            echo "Error Occurred: " . $e->getMessage();
        }
    }
}
