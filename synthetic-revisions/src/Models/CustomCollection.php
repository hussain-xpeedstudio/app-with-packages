<?php

namespace SyntheticRevisions\Models;

use Illuminate\Database\Eloquent\Collection;
use DB;

class CustomCollection extends Collection
{
    /**
     * Perform a custom operation on the collection.
     *
     * @return mixed
     */

    /**
     * work with json data field and compare variable to variable
     */
    public function generateData($new, $old): array
    {
        // $oldData = json_decode($old->data, true);
        // $newData = json_decode($new->data, true);

        // $channgeArray = [];
        // foreach ($oldData as $key => $value) {
        //     if ($oldData[$key] != $newData[$key]) {
        //         $channgeArray[$key] = [
        //             'oldValue' => $oldData[$key],
        //             'newData' => $newData[$key]
        //         ];
        //     }
        // }

        // return $channgeArray;
    }

    /**
     * Pass only object onto old value and new value
     */
    public function generateDataObject($new, $old): array
    {
        return [
            'oldValue' => $old['data'],
            'newValue' => $new['data']
        ];
    }

    public function compare()
    {
        $lastData = $this->last();
        $dynamicTable = $lastData->getTable();

        $afterEndData = DB::table($dynamicTable)->where([
            ['created_at', '>', $lastData->created_at],
            'model_id' => $lastData->model_id
        ])->first();

        $data = $this->toArray();

        if (!is_null($afterEndData)) {
            $data[] = $afterEndData;
        }

        if (count($data) < 2) {
            throw new \Exception('Not enough row in [' . $dynamicTable . '] table to compare');
        }
        $oldvalue = null;
        $procesedData = [];

        foreach ($data as $key => $value) {
            if ($key == 0) {
                $oldvalue = $value;
            } else {
                $procesedData[] = $this->generateDataObject($value, $oldvalue);
                $oldvalue = $value;
            }
        }
        return $procesedData;
    }
}
