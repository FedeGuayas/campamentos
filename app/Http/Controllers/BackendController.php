<?php

namespace App\Http\Controllers;

use App\Inscripcion;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{

    public function getDashboard()
    {

        //ventas por mes y año data=mes,total,anio
        $ventas = DB::table('inscripcions')
            ->select(DB::raw('MONTH( created_at ) AS mes, estado , deleted_at , COUNT( * ) AS total, YEAR(created_at) as anio'))
            ->where('estado', '=', 'Pagada')
            ->where('deleted_at', null)
            ->groupBy(['mes', 'anio'])
            ->get();

        $array_data = [];
        foreach ($ventas as $key => $v) {
            $array_data[$v->anio][$v->mes] = [ //totales por anio y mes
                'total' => $v->total,
            ];
        }

        $chart_data=[];
        foreach ($array_data as $key=>$value) {
            $rgb = $this->dynamicColors(0.7);
            $data = [];
            foreach ($value as $v) {

//                $data[] =  $v['total'];

                for ($i = 0; $i < 12; $i++) {

                    if ((key($value) - 1) == $i) {
                        $data[$i][] = $v['total'];
                    } else {
                        $data[$i][] = 0;
                    }
                }
                // key($value);//mes 1,2,3,....12
//            dd($key);//anio 2017...2019
            }
            $values = array_flatten($data);
//            dd($data);
            $chart_data[] = [
                "label" => 'Insc ' . $key,
                'backgroundColor' => $rgb,
                'borderColor' => $rgb,
                "pointBorderColor" => $rgb,
                "pointBackgroundColor" => $rgb,
                "pointHoverBackgroundColor" => $rgb,
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "fill" => "false",
                'data' => $values
            ];

        }

        $ventas_chartjs = app()->chartjs
            ->name('ventasLineChart')
            ->type('line')
            ->size(['width' => 200, 'height' => 200])
            ->labels(
                ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
            )
            ->datasets(
                $chart_data
//                [
//                [
//                    "label" => "Ventas 2017",
//                    'backgroundColor' => $rgb,
//                    'borderColor' => $rgb,
//                    "pointBorderColor" => $rgb,
//                    "pointBackgroundColor" => $rgb,
//                    "pointHoverBackgroundColor" => "#fff",
//                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
//                    "fill" => "false",
//                    'data' => [0, 23, 65, 23, 34, 45, 78, 22, 66, 45,56,98]
//                ],
//                [
//                    "label" => "Ventas 2018",
//                    'backgroundColor' => "rgba(255, 99, 132, 1)",
//                    'borderColor' => "rgba(255, 99, 132, 1)",
//                    "pointBorderColor" => "rgba(255, 99, 132, 1)",
//                    "pointBackgroundColor" => "rgba(255, 99, 132, 1)",
//                    "pointHoverBackgroundColor" => "#fff",
//                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
//                    "fill"=> "false",
//                    'data' => [10, 24, 63, 43, 24, 56, 48, 32, 67, 54,33,25]
//                ],
//                [
//                    "label" => "Ventas 2019",
//                    'backgroundColor' => "rgba(38, 185, 154, 1)",
//                    'borderColor' => "rgba(38, 185, 154, 1)",
//                    "pointBorderColor" => "rgba(38, 185, 154, 1)",
//                    "pointBackgroundColor" => "rgba(38, 185, 154, 1)",
//                    "pointHoverBackgroundColor" => "#fff",
//                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
//                    "fill"=> "false",
//                    'data' => [5, 21, 36, 23, 94, 54, 35, 12, 6, 14,30,60]
//                ]
//            ]
            )
            ->optionsRaw("{
                             scales: {
                                yAxes: [{
                                        ticks: {
                                                beginAtZero:true
                                                }
                                        }]
                                     },
                             title: {
                                    display: true,
                                    text: 'Inscripciones anuales'
                                    }
                            }");

        return view('back.dashboard', compact('ventas_chartjs'));

    }

    private function dynamicColors($opacity=1)
    {
        $r = mt_rand(0, 255);
        $g = mt_rand(0, 255);
        $b = mt_rand(0, 255);
        return "rgb(" . $r . "," . $g . "," . $b . "," .$opacity . ")";
    }


}
