<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NRCStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = '[
            {
            "code_id": 11,
            "name": "Kha Tha Kha"
            },
            {
            "code_id": 13,
            "name": "Pa Ma Na"
            },
            {
            "code_id": 3,
            "name": "YA KA NA"
            },
            {
            "code_id": 3,
            "name": "YA BA YA"
            },
            {
            "code_id": 3,
            "name": "WA MA NA"
            },
            {
            "code_id": 3,
            "name": "TA NA NA"
            },
            {
            "code_id": 3,
            "name": "SA PA BA"
            },
            {
            "code_id": 3,
            "name": "SA LA NA"
            },
            {
            "code_id": 3,
            "name": "SA DA NA"
            },
            {
            "code_id": 3,
            "name": "SA BA TA"
            },
            {
            "code_id": 3,
            "name": "PA WA NA"
            },
            {
            "code_id": 3,
            "name": "PA TA AH"
            },
            {
            "code_id": 3,
            "name": "PA NA DA"
            },
            {
            "code_id": 3,
            "name": "NA MA NA"
            },
            {
            "code_id": 6,
            "name": "MA SA NA"
            },
            {
            "code_id": 3,
            "name": "MA NYA NA"
            },
            {
            "code_id": 3,
            "name": "MA MA NA"
            },
            {
            "code_id": 3,
            "name": "MA LA NA"
            },
            {
            "code_id": 3,
            "name": "MA KHA BA"
            },
            {
            "code_id": 3,
            "name": "MA KA TA"
            },
            {
            "code_id": 3,
            "name": "MA KA NA"
            },
            {
            "code_id": 3,
            "name": "LA GA NA"
            },
            {
            "code_id": 3,
            "name": "KHA PHA NA"
            },
            {
            "code_id": 3,
            "name": "KHA BA DA"
            },
            {
            "code_id": 3,
            "name": "KA PA TA"
            },
            {
            "code_id": 3,
            "name": "KA MA TA"
            },
            {
            "code_id": 3,
            "name": "KA MA NA"
            },
            {
            "code_id": 3,
            "name": "HA PA NA"
            },
            {
            "code_id": 3,
            "name": "DA PHA YA"
            },
            {
            "code_id": 3,
            "name": "BA MA NA"
            },
            {
            "code_id": 3,
            "name": "AH GA YA"
            },
            {
            "code_id": 6,
            "name": "YA THA NA"
            },
            {
            "code_id": 6,
            "name": "YA TA NA"
            },
            {
            "code_id": 6,
            "name": "PHA YA SA"
            },
            {
            "code_id": 6,
            "name": "PHA SA NA"
            },
            {
            "code_id": 3,
            "name": "LA KA NA"
            },
            {
            "code_id": 6,
            "name": "DA MA SA"
            },
            {
            "code_id": 6,
            "name": "BA LA KHA"
            },
            {
            "code_id": 6,
            "name": "LA KA NA"
            },
            {
            "code_id": 7,
            "name": "BA THA SA"
            },
            {
            "code_id": 7,
            "name": "YA YA THA"
            },
            {
            "code_id": 7,
            "name": "WA LA MA"
            },
            {
            "code_id": 7,
            "name": "THA TA KA"
            },
            {
            "code_id": 7,
            "name": "SA KA LA"
            },
            {
            "code_id": 7,
            "name": "PHA PA NA"
            },
            {
            "code_id": 7,
            "name": "PA KA NA"
            },
            {
            "code_id": 7,
            "name": "MA WA TA"
            },
            {
            "code_id": 7,
            "name": "LA THA NA"
            },
            {
            "code_id": 7,
            "name": "LA BA NA"
            },
            {
            "code_id": 7,
            "name": "KA SA KA"
            },
            {
            "code_id": 7,
            "name": "KA MA MA"
            },
            {
            "code_id": 7,
            "name": "KA KA YA"
            },
            {
            "code_id": 7,
            "name": "KA DA NA"
            },
            {
            "code_id": 7,
            "name": "BA GA LA"
            },
            {
            "code_id": 7,
            "name": "BA AH NA"
            },
            {
            "code_id": 8,
            "name": "YA ZA NA"
            },
            {
            "code_id": 8,
            "name": "YA KHA DA"
            },
            {
            "code_id": 8,
            "name": "TA ZA NA"
            },
            {
            "code_id": 8,
            "name": "TA TA NA"
            },
            {
            "code_id": 8,
            "name": "SA MA NA"
            },
            {
            "code_id": 8,
            "name": "PHA LA NA"
            },
            {
            "code_id": 8,
            "name": "PA LA WA"
            },
            {
            "code_id": 8,
            "name": "MA TA PA"
            },
            {
            "code_id": 8,
            "name": "MA TA NA"
            },
            {
            "code_id": 8,
            "name": "KA PA LA"
            },
            {
            "code_id": 8,
            "name": "KA KHA NA"
            },
            {
            "code_id": 8,
            "name": "HTA TA LA"
            },
            {
            "code_id": 8,
            "name": "HA KHA NA"
            },
            {
            "code_id": 9,
            "name": "YA OU NA"
            },
            {
            "code_id": 9,
            "name": "YA MA PA"
            },
            {
            "code_id": 9,
            "name": "YA BA NA"
            },
            {
            "code_id": 9,
            "name": "WA THA NA"
            },
            {
            "code_id": 9,
            "name": "WA LA NA"
            },
            {
            "code_id": 9,
            "name": "TA SA NA"
            },
            {
            "code_id": 9,
            "name": "TA MA NA"
            },
            {
            "code_id": 9,
            "name": "SA MA YA"
            },
            {
            "code_id": 9,
            "name": "SA LA KA"
            },
            {
            "code_id": 9,
            "name": "SA KA NA"
            },
            {
            "code_id": 9,
            "name": "PHA PA NA"
            },
            {
            "code_id": 9,
            "name": "PA SA NA"
            },
            {
            "code_id": 9,
            "name": "PA LA NA"
            },
            {
            "code_id": 9,
            "name": "PA LA BA"
            },
            {
            "code_id": 9,
            "name": "NA YA NA"
            },
            {
            "code_id": 9,
            "name": "MA YA NA"
            },
            {
            "code_id": 9,
            "name": "MA THA NA"
            },
            {
            "code_id": 9,
            "name": "MA PA LA"
            },
            {
            "code_id": 9,
            "name": "MA MA TA"
            },
            {
            "code_id": 9,
            "name": "MA MA NA"
            },
            {
            "code_id": 9,
            "name": "MA LA NA"
            },
            {
            "code_id": 9,
            "name": "MA KA NA"
            },
            {
            "code_id": 9,
            "name": "LA YA NA"
            },
            {
            "code_id": 9,
            "name": "LA HA NA"
            },
            {
            "code_id": 9,
            "name": "KHA PA NA"
            },
            {
            "code_id": 9,
            "name": "KHA OU TA"
            },
            {
            "code_id": 9,
            "name": "KHA OU NA"
            },
            {
            "code_id": 9,
            "name": "KA THA NA"
            },
            {
            "code_id": 9,
            "name": "KA NA NA"
            },
            {
            "code_id": 9,
            "name": "KA MA NA"
            },
            {
            "code_id": 9,
            "name": "KA LA WA"
            },
            {
            "code_id": 9,
            "name": "KA LA TA"
            },
            {
            "code_id": 9,
            "name": "KA LA NA"
            },
            {
            "code_id": 9,
            "name": "KA LA HTA"
            },
            {
            "code_id": 9,
            "name": "KA BA LA"
            },
            {
            "code_id": 9,
            "name": "HTA PA KHA"
            },
            {
            "code_id": 9,
            "name": "HTA KHA NA"
            },
            {
            "code_id": 9,
            "name": "HA MA LA"
            },
            {
            "code_id": 9,
            "name": "DA PA YA"
            },
            {
            "code_id": 9,
            "name": "DA HA NA"
            },
            {
            "code_id": 9,
            "name": "BA TA LA"
            },
            {
            "code_id": 9,
            "name": "BA MA NA"
            },
            {
            "code_id": 9,
            "name": "AH YA TA"
            },
            {
            "code_id": 9,
            "name": "AH TA NA"
            },
            {
            "code_id": 10,
            "name": "YA PHA NA"
            },
            {
            "code_id": 10,
            "name": "THA YA KHA"
            },
            {
            "code_id": 10,
            "name": "TA THA YA"
            },
            {
            "code_id": 10,
            "name": "PA LA TA"
            },
            {
            "code_id": 10,
            "name": "PA LA NA"
            },
            {
            "code_id": 10,
            "name": "PA KA MA"
            },
            {
            "code_id": 10,
            "name": "MA TA NA"
            },
            {
            "code_id": 10,
            "name": "MA MA NA"
            },
            {
            "code_id": 10,
            "name": "MA AH YA"
            },
            {
            "code_id": 10,
            "name": "MA AH NA"
            },
            {
            "code_id": 10,
            "name": "LA LA NA"
            },
            {
            "code_id": 10,
            "name": "KHA MA KA"
            },
            {
            "code_id": 10,
            "name": "KA YA YA"
            },
            {
            "code_id": 10,
            "name": "KA THA NA"
            },
            {
            "code_id": 10,
            "name": "KA SA NA"
            },
            {
            "code_id": 10,
            "name": "KA LA AH"
            },
            {
            "code_id": 10,
            "name": "HTA WA NA"
            },
            {
            "code_id": 10,
            "name": "BA PA NA"
            },
            {
            "code_id": 11,
            "name": "ZA KA NA"
            },
            {
            "code_id": 11,
            "name": "YA TA YA"
            },
            {
            "code_id": 11,
            "name": "YA TA NA"
            },
            {
            "code_id": 11,
            "name": "YA KA NA"
            },
            {
            "code_id": 11,
            "name": "WA MA NA"
            },
            {
            "code_id": 11,
            "name": "THA WA TA"
            },
            {
            "code_id": 11,
            "name": "THA NA PA"
            },
            {
            "code_id": 11,
            "name": "THA KA NA"
            },
            {
            "code_id": 11,
            "name": "TA NGA NA"
            },
            {
            "code_id": 11,
            "name": "PHA MA NA"
            },
            {
            "code_id": 11,
            "name": "PA TA TA"
            },
            {
            "code_id": 11,
            "name": "PA TA NA"
            },
            {
            "code_id": 11,
            "name": "PA MA NA"
            },
            {
            "code_id": 11,
            "name": "PA KHA TA"
            },
            {
            "code_id": 11,
            "name": "PA KHA NA"
            },
            {
            "code_id": 11,
            "name": "NYA LA PA"
            },
            {
            "code_id": 11,
            "name": "NA TA LA"
            },
            {
            "code_id": 11,
            "name": "MA NYA NA"
            },
            {
            "code_id": 11,
            "name": "MA LA NA"
            },
            {
            "code_id": 11,
            "name": "LA PA TA"
            },
            {
            "code_id": 11,
            "name": "KA WA NA"
            },
            {
            "code_id": 11,
            "name": "KA TA KHA"
            },
            {
            "code_id": 11,
            "name": "KA PA KA"
            },
            {
            "code_id": 11,
            "name": "KA KA NA"
            },
            {
            "code_id": 11,
            "name": "HTA TA PA"
            },
            {
            "code_id": 11,
            "name": "DA OU NA"
            },
            {
            "code_id": 11,
            "name": "AH TA NA"
            },
            {
            "code_id": 11,
            "name": "AH PHA NA"
            },
            {
            "code_id": 12,
            "name": "YA SA KA"
            },
            {
            "code_id": 12,
            "name": "YA NA KHA"
            },
            {
            "code_id": 12,
            "name": "THA YA NA"
            },
            {
            "code_id": 11,
            "name": "TA TA KA"
            },
            {
            "code_id": 12,
            "name": "SA TA YA"
            },
            {
            "code_id": 12,
            "name": "SA PHA NA"
            },
            {
            "code_id": 12,
            "name": "SA PA WA"
            },
            {
            "code_id": 12,
            "name": "SA MA NA"
            },
            {
            "code_id": 12,
            "name": "SA LA NA"
            },
            {
            "code_id": 12,
            "name": "PA PHA NA"
            },
            {
            "code_id": 12,
            "name": "PA MA NA"
            },
            {
            "code_id": 12,
            "name": "PA KHA KA"
            },
            {
            "code_id": 12,
            "name": "NGA PHA NA"
            },
            {
            "code_id": 12,
            "name": "NA MA NA"
            },
            {
            "code_id": 12,
            "name": "MA THA NA"
            },
            {
            "code_id": 12,
            "name": "MA TA NA"
            },
            {
            "code_id": 12,
            "name": "MA MA NA"
            },
            {
            "code_id": 12,
            "name": "MA KA NA"
            },
            {
            "code_id": 12,
            "name": "MA HTA NA"
            },
            {
            "code_id": 12,
            "name": "MA BA NA"
            },
            {
            "code_id": 12,
            "name": "KHA MA NA"
            },
            {
            "code_id": 12,
            "name": "KA MA NA"
            },
            {
            "code_id": 12,
            "name": "KA HTA NA"
            },
            {
            "code_id": 12,
            "name": "HTA LA NA"
            },
            {
            "code_id": 12,
            "name": "GA GA NA"
            },
            {
            "code_id": 12,
            "name": "AH LA NA"
            },
            {
            "code_id": 13,
            "name": "ZA YA THA"
            },
            {
            "code_id": 13,
            "name": "ZA BA THA"
            },
            {
            "code_id": 13,
            "name": "YA MA THA"
            },
            {
            "code_id": 13,
            "name": "WA TA NA"
            },
            {
            "code_id": 13,
            "name": "THA SA NA"
            },
            {
            "code_id": 13,
            "name": "THA PA KA"
            },
            {
            "code_id": 13,
            "name": "TA THA NA"
            },
            {
            "code_id": 13,
            "name": "TA TA OU"
            },
            {
            "code_id": 13,
            "name": "TA KA TA"
            },
            {
            "code_id": 13,
            "name": "TA KA NA"
            },
            {
            "code_id": 13,
            "name": "SA KA TA"
            },
            {
            "code_id": 13,
            "name": "SA KA NA"
            },
            {
            "code_id": 13,
            "name": "PA THA KA"
            },
            {
            "code_id": 13,
            "name": "PA OU LA"
            },
            {
            "code_id": 13,
            "name": "PA KA KHA"
            },
            {
            "code_id": 13,
            "name": "PA BA THA"
            },
            {
            "code_id": 13,
            "name": "PA BA NA"
            },
            {
            "code_id": 13,
            "name": "OU TA THA"
            },
            {
            "code_id": 13,
            "name": "NYA OU NA"
            },
            {
            "code_id": 13,
            "name": "NGA ZA NA"
            },
            {
            "code_id": 13,
            "name": "NGA THA YA"
            },
            {
            "code_id": 13,
            "name": "NA HTA KA"
            },
            {
            "code_id": 13,
            "name": "MA YA TA"
            },
            {
            "code_id": 13,
            "name": "MA YA MA"
            },
            {
            "code_id": 13,
            "name": "MA THA NA"
            },
            {
            "code_id": 13,
            "name": "MA TA YA"
            },
            {
            "code_id": 13,
            "name": "MA NA TA"
            },
            {
            "code_id": 13,
            "name": "MA NA MA"
            },
            {
            "code_id": 13,
            "name": "MA MA NA"
            },
            {
            "code_id": 13,
            "name": "MA LA NA"
            },
            {
            "code_id": 13,
            "name": "MA KHA NA"
            },
            {
            "code_id": 13,
            "name": "MA KA NA"
            },
            {
            "code_id": 13,
            "name": "MA HTA LA"
            },
            {
            "code_id": 13,
            "name": "MA HA MA"
            },
            {
            "code_id": 13,
            "name": "LA WA NA"
            },
            {
            "code_id": 13,
            "name": "KHA MA SA"
            },
            {
            "code_id": 13,
            "name": "KHA AH ZA"
            },
            {
            "code_id": 13,
            "name": "KA SA NA"
            },
            {
            "code_id": 13,
            "name": "KA PA TA"
            },
            {
            "code_id": 13,
            "name": "DA KHA THA"
            },
            {
            "code_id": 13,
            "name": "AH MA ZA"
            },
            {
            "code_id": 13,
            "name": "AH MA YA"
            },
            {
            "code_id": 14,
            "name": "YA MA NA"
            },
            {
            "code_id": 13,
            "name": "THA PHA YA"
            },
            {
            "code_id": 14,
            "name": "THA HTA NA"
            },
            {
            "code_id": 14,
            "name": "PA MA NA"
            },
            {
            "code_id": 14,
            "name": "MA LA NA"
            },
            {
            "code_id": 14,
            "name": "MA DA NA"
            },
            {
            "code_id": 14,
            "name": "LA MA NA"
            },
            {
            "code_id": 14,
            "name": "KHA ZA NA"
            },
            {
            "code_id": 14,
            "name": "KHA SA NA"
            },
            {
            "code_id": 14,
            "name": "KA MA YA"
            },
            {
            "code_id": 18,
            "name": "ZA LA NA"
            },
            {
            "code_id": 14,
            "name": "KA HTA NA"
            },
            {
            "code_id": 14,
            "name": "BA LA NA"
            },
            {
            "code_id": 15,
            "name": "YA THA TA"
            },
            {
            "code_id": 15,
            "name": "YA BA NA"
            },
            {
            "code_id": 15,
            "name": "THA TA NA"
            },
            {
            "code_id": 18,
            "name": "ZA LA NA"
            },
            {
            "code_id": 15,
            "name": "TA PA WA"
            },
            {
            "code_id": 15,
            "name": "TA KA NA"
            },
            {
            "code_id": 18,
            "name": "YA THA YA"
            },
            {
            "code_id": 15,
            "name": "SA TA NA"
            },
            {
            "code_id": 18,
            "name": "YA KA NA"
            },
            {
            "code_id": 15,
            "name": "PA NA KA"
            },
            {
            "code_id": 18,
            "name": "WA KHA MA"
            },
            {
            "code_id": 15,
            "name": "MA TA NA"
            },
            {
            "code_id": 18,
            "name": "THA PA NA"
            },
            {
            "code_id": 15,
            "name": "MA PA TA"
            },
            {
            "code_id": 18,
            "name": "PHA PA NA"
            },
            {
            "code_id": 15,
            "name": "MA PA NA"
            },
            {
            "code_id": 18,
            "name": "PA THA YA"
            },
            {
            "code_id": 15,
            "name": "MA OU NA"
            },
            {
            "code_id": 18,
            "name": "PA THA NA"
            },
            {
            "code_id": 13,
            "name": "MA AH TA"
            },
            {
            "code_id": 18,
            "name": "PA TA NA"
            },
            {
            "code_id": 15,
            "name": "MA AH NA"
            },
            {
            "code_id": 18,
            "name": "PA SA LA"
            },
            {
            "code_id": 15,
            "name": "KA TA NA"
            },
            {
            "code_id": 15,
            "name": "KA TA LA"
            },
            {
            "code_id": 18,
            "name": "NYA TA NA"
            },
            {
            "code_id": 15,
            "name": "KA PHA NA"
            },
            {
            "code_id": 18,
            "name": "NGA YA KA"
            },
            {
            "code_id": 15,
            "name": "GA MA NA"
            },
            {
            "code_id": 15,
            "name": "BA THA TA"
            },
            {
            "code_id": 18,
            "name": "NGA SA NA"
            },
            {
            "code_id": 15,
            "name": "AH MA NA"
            },
            {
            "code_id": 18,
            "name": "NGA PA TA"
            },
            {
            "code_id": 18,
            "name": "MA MA NA"
            },
            {
            "code_id": 16,
            "name": "YA PA THA"
            },
            {
            "code_id": 18,
            "name": "MA MA KA"
            },
            {
            "code_id": 13,
            "name": "YA KA NA"
            },
            {
            "code_id": 18,
            "name": "MA AH PA"
            },
            {
            "code_id": 16,
            "name": "THA LA NA"
            },
            {
            "code_id": 16,
            "name": "THA KHA NA"
            },
            {
            "code_id": 18,
            "name": "MA AH NA"
            },
            {
            "code_id": 16,
            "name": "THA KA TA"
            },
            {
            "code_id": 18,
            "name": "LA PA TA"
            },
            {
            "code_id": 13,
            "name": "THA GA KA"
            },
            {
            "code_id": 18,
            "name": "LA MA NA"
            },
            {
            "code_id": 16,
            "name": "TA TA TA"
            },
            {
            "code_id": 18,
            "name": "KA PA NA"
            },
            {
            "code_id": 16,
            "name": "TA TA NA"
            },
            {
            "code_id": 18,
            "name": "KA LA NA"
            },
            {
            "code_id": 16,
            "name": "TA MA NA"
            },
            {
            "code_id": 16,
            "name": "TA KA NA"
            },
            {
            "code_id": 18,
            "name": "KA KHA NA"
            },
            {
            "code_id": 18,
            "name": "KA KA NA"
            },
            {
            "code_id": 16,
            "name": "SA MA HA"
            },
            {
            "code_id": 16,
            "name": "SA KHA NA"
            },
            {
            "code_id": 18,
            "name": "KA KA HTA"
            },
            {
            "code_id": 18,
            "name": "KA THA TA"
            },
            {
            "code_id": 18,
            "name": "HA KA KA"
            },
            {
            "code_id": 18,
            "name": "DA NA PHA"
            },
            {
            "code_id": 18,
            "name": "DA DA YA"
            },
            {
            "code_id": 16,
            "name": "SA KA NA"
            },
            {
            "code_id": 18,
            "name": "BA KA LA"
            },
            {
            "code_id": 16,
            "name": "SA KA KHA"
            },
            {
            "code_id": 18,
            "name": "AH MA TA"
            },
            {
            "code_id": 16,
            "name": "PA ZA TA"
            },
            {
            "code_id": 18,
            "name": "AH MA NA"
            },
            {
            "code_id": 16,
            "name": "PA BA TA"
            },
            {
            "code_id": 18,
            "name": "AH GA PA"
            },
            {
            "code_id": 17,
            "name": "YA SA NA"
            },
            {
            "code_id": 16,
            "name": "OU KA TA"
            },
            {
            "code_id": 17,
            "name": "YA NGA NA"
            },
            {
            "code_id": 16,
            "name": "OU KA MA"
            },
            {
            "code_id": 17,
            "name": "THA PA NA"
            },
            {
            "code_id": 16,
            "name": "MA YA KA"
            },
            {
            "code_id": 17,
            "name": "THA NA NA"
            },
            {
            "code_id": 16,
            "name": "MA GA TA"
            },
            {
            "code_id": 17,
            "name": "TA YA NA"
            },
            {
            "code_id": 17,
            "name": "TA TA NA"
            },
            {
            "code_id": 16,
            "name": "MA GA DA"
            },
            {
            "code_id": 16,
            "name": "MA BA NA"
            },
            {
            "code_id": 17,
            "name": "TA MA NYA"
            },
            {
            "code_id": 17,
            "name": "TA LA NA"
            },
            {
            "code_id": 16,
            "name": "LA THA YA"
            },
            {
            "code_id": 17,
            "name": "TA KHA LA"
            },
            {
            "code_id": 16,
            "name": "LA THA NA"
            },
            {
            "code_id": 17,
            "name": "TA KA NA"
            },
            {
            "code_id": 16,
            "name": "LA MA TA"
            },
            {
            "code_id": 17,
            "name": "SA SA NA"
            },
            {
            "code_id": 17,
            "name": "PHA KHA NA"
            },
            {
            "code_id": 16,
            "name": "LA MA NA"
            },
            {
            "code_id": 16,
            "name": "LA KA NA"
            },
            {
            "code_id": 17,
            "name": "PA YA NA"
            },
            {
            "code_id": 16,
            "name": "KHA YA NA"
            },
            {
            "code_id": 17,
            "name": "PA WA NA"
            },
            {
            "code_id": 16,
            "name": "KA TA TA"
            },
            {
            "code_id": 17,
            "name": "PA TA YA"
            },
            {
            "code_id": 16,
            "name": "KA TA NA"
            },
            {
            "code_id": 17,
            "name": "PA SA TA"
            },
            {
            "code_id": 16,
            "name": "KA MA YA"
            },
            {
            "code_id": 17,
            "name": "PA SA NA"
            },
            {
            "code_id": 17,
            "name": "PA PA KA"
            },
            {
            "code_id": 16,
            "name": "KA MA TA"
            },
            {
            "code_id": 17,
            "name": "PA LA TA"
            },
            {
            "code_id": 16,
            "name": "KA MA NA"
            },
            {
            "code_id": 17,
            "name": "PA LA NA"
            },
            {
            "code_id": 16,
            "name": "KA KHA KA"
            },
            {
            "code_id": 16,
            "name": "KA KA KA"
            },
            {
            "code_id": 17,
            "name": "NYA YA NA"
            },
            {
            "code_id": 16,
            "name": "HTA TA PA"
            },
            {
            "code_id": 17,
            "name": "NA TA YA"
            },
            {
            "code_id": 16,
            "name": "DA PA NA"
            },
            {
            "code_id": 16,
            "name": "DA LA NA"
            },
            {
            "code_id": 16,
            "name": "DA GA YA"
            },
            {
            "code_id": 16,
            "name": "DA GA TA"
            },
            {
            "code_id": 16,
            "name": "DA GA SA"
            },
            {
            "code_id": 16,
            "name": "DA GA NA"
            },
            {
            "code_id": 16,
            "name": "BA TA HTA"
            },
            {
            "code_id": 17,
            "name": "NA TA NA"
            },
            {
            "code_id": 16,
            "name": "BA HA NA"
            },
            {
            "code_id": 16,
            "name": "AH SA NA"
            },
            {
            "code_id": 17,
            "name": "NA SA NA"
            },
            {
            "code_id": 16,
            "name": "AH LA NA"
            },
            {
            "code_id": 17,
            "name": "NA PHA NA"
            },
            {
            "code_id": 17,
            "name": "NA MA TA"
            },
            {
            "code_id": 17,
            "name": "KA LA DA"
            },
            {
            "code_id": 17,
            "name": "NA KHA TA"
            },
            {
            "code_id": 17,
            "name": "NA KHA NA"
            },
            {
            "code_id": 17,
            "name": "MA YA TA"
            },
            {
            "code_id": 17,
            "name": "KA KHA NA"
            },
            {
            "code_id": 17,
            "name": "MA YA NA"
            },
            {
            "code_id": 17,
            "name": "MA YA HTA"
            },
            {
            "code_id": 17,
            "name": "KA KA NA"
            },
            {
            "code_id": 17,
            "name": "MA TA TA"
            },
            {
            "code_id": 17,
            "name": "KA HA NA"
            },
            {
            "code_id": 17,
            "name": "MA TA NA"
            },
            {
            "code_id": 17,
            "name": "HA PA TA"
            },
            {
            "code_id": 17,
            "name": "MA SA TA"
            },
            {
            "code_id": 17,
            "name": "MA SA NA"
            },
            {
            "code_id": 17,
            "name": "HA PA NA"
            },
            {
            "code_id": 17,
            "name": "MA PHA TA"
            },
            {
            "code_id": 17,
            "name": "HA MA NA"
            },
            {
            "code_id": 17,
            "name": "MA PHA NA"
            },
            {
            "code_id": 17,
            "name": "AH TA NA"
            },
            {
            "code_id": 17,
            "name": "MA PA TA"
            },
            {
            "code_id": 17,
            "name": "LA KA NA"
            },
            {
            "code_id": 17,
            "name": "MA PA NA"
            },
            {
            "code_id": 17,
            "name": "KHA YA HA"
            },
            {
            "code_id": 17,
            "name": "MA NGA NA"
            },
            {
            "code_id": 17,
            "name": "KHA LA NA"
            },
            {
            "code_id": 17,
            "name": "MA NA TA"
            },
            {
            "code_id": 17,
            "name": "KA THA NA"
            },
            {
            "code_id": 17,
            "name": "MA NA NA"
            },
            {
            "code_id": 17,
            "name": "MA MA TA"
            },
            {
            "code_id": 17,
            "name": "KA TA TA"
            },
            {
            "code_id": 17,
            "name": "MA MA NA"
            },
            {
            "code_id": 17,
            "name": "KA TA NA"
            },
            {
            "code_id": 17,
            "name": "MA MA HTA"
            },
            {
            "code_id": 17,
            "name": "KA TA LA"
            },
            {
            "code_id": 17,
            "name": "MA LA TA"
            },
            {
            "code_id": 17,
            "name": "KA MA NA"
            },
            {
            "code_id": 16,
            "name": "MA LA NA"
            },
            {
            "code_id": 17,
            "name": "KA LA TA"
            },
            {
            "code_id": 16,
            "name": "MA KHA TA"
            },
            {
            "code_id": 17,
            "name": "KA LA NA"
            },
            {
            "code_id": 17,
            "name": "MA KA NA"
            },
            {
            "code_id": 17,
            "name": "MA KHA NA"
            },
            {
            "code_id": 17,
            "name": "MA KA HTA"
            },
            {
            "code_id": 17,
            "name": "MA KA TA"
            },
            {
            "code_id": 17,
            "name": "MA HTA TA"
            },
            {
            "code_id": 17,
            "name": "MA HTA NA"
            },
            {
            "code_id": 17,
            "name": "MA HA YA"
            },
            {
            "code_id": 17,
            "name": "MA BA NA"
            },
            {
            "code_id": 17,
            "name": "LA YA NA"
            },
            {
            "code_id": 17,
            "name": "LA LA NA"
            },
            {
            "code_id": 17,
            "name": "LA KHA TA"
            },
            {
            "code_id": 17,
            "name": "LA KHA NA"
            },
            {
            "code_id": 13,
            "name": "Ma La Ma"
            },
            {
            "code_id": 14,
            "name": "Ma La Ma"
            },
            {
            "code_id": 12,
            "name": "MA LA NA"
            },
            {
            "code_id": 12,
            "name": "TA TA KA"
            },
            {
            "code_id": 16,
            "name": "YA KA NA"
            },
            {
            "code_id": 16,
            "name": "DA GA MA"
            },
            {
            "code_id": 3,
            "name": "Ma SA NA"
            },
            {
            "code_id": 16,
            "name": "THA GA Ka"
            },
            {
            "code_id": 14,
            "name": "THA PHA YA"
            },
            {
            "code_id": 18,
            "name": "HA THA TA"
            },
            {
            "code_id": 15,
            "name": "PA TA NA"
            },
            {
            "code_id": 11,
            "name": "WA TA NA"
            },
            {
            "code_id": 9,
            "name": "NGA ZA NA"
            },
            {
            "code_id": 13,
            "name": "PA THA NA"
            },
            {
            "code_id": 13,
            "name": "Ta Ta Ka"
            },
            {
            "code_id": 13,
            "name": "Ba Aa Na"
            },
            {
            "code_id": 10,
            "name": "LA PA TA"
            },
            {
            "code_id": 13,
            "name": "PA KHA NA"
            },
            {
            "code_id": 8,
            "name": "Ma HTA NA"
            },
            {
            "code_id": 12,
            "name": "SA PA TA"
            },
            {
            "code_id": 12,
            "name": "SA PA NA"
            },
            {
            "code_id": 12,
            "name": "MA NYA NA"
            },
            {
            "code_id": 9,
            "name": "KHA TA NA"
            },
            {
            "code_id": 11,
            "name": "LA KA NA"
            },
            {
            "code_id": 15,
            "name": "KA HTA NA"
            }
            ]';



        $result = json_decode($data);


        // insert

        foreach ($result as $data) {
            DB::table('nrcstate')->insert([
                'code_id' => $data->code_id,
                'name' => $data->name,
            ]);
        }
    }
}