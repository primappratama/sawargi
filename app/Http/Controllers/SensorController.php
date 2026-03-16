<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SensorController extends Controller
{
    public function getRainFromBMKG()
    {
        try {
            $response = Http::get('https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaBarat.xml');

            if ($response->failed()) return response()->json(['rain' => 0.0]);

            $xml = simplexml_load_string($response->body());
            $rainAmount = 0.0;

            foreach ($xml->forecast->area as $area) {
                if ((string)$area['description'] == "Kota Sukabumi") {
                    foreach ($area->parameter as $param) {
                        if ((string)$param['id'] == "weather") {
                            $weatherCode = (int)$param->timerange[0]->value;
                            switch ($weatherCode) {
                                case 60: $rainAmount = 5.0;   break;
                                case 61: $rainAmount = 20.0;  break;
                                case 63: $rainAmount = 50.0;  break;
                                case 95:
                                case 97: $rainAmount = 100.0; break;
                                default: $rainAmount = 0.0;   break;
                            }
                            break 2;
                        }
                    }
                }
            }
            return response()->json(['rain' => $rainAmount]);

        } catch (\Exception $e) {
            Log::error("BMKG Sync Error: " . $e->getMessage());
            return response()->json(['rain' => 0.0]);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = SensorData::create([
                'gyro_x'        => $request->gyro_x    ?? 0,
                'gyro_y'        => $request->gyro_y    ?? 0,
                'gyro_z'        => $request->gyro_z    ?? 0,
                'soil_moisture' => $request->soil      ?? 0,
                'rainfall'      => $request->rain      ?? 0,
                'suhu'          => $request->suhu      ?? 0,
                'status'        => $request->status    ?? 0,
                'latitude'      => $request->lat       ?? 0,
                'longitude'     => $request->lng       ?? 0,
            ]);
            return response()->json(['status' => 'success', 'data' => $data], 201);

        } catch (\Exception $e) {
            Log::error("IoT Store Error: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $data = SensorData::orderBy('id', 'desc')
                ->take(15)
                ->get()
                ->reverse()
                ->values();
        return response()->json($data);
    }
}