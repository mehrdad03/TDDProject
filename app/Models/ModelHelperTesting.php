<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

trait ModelHelperTesting
{
    public function test_insert_data(): void
    {
        $model = $this->model();
        $table = $model->getTable();
        $data = $model::factory()->make()->toArray();

        if ($model instanceof User){
            $data['password'] = Hash::make(123456);
            $data['email_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');
        }

        $model::query()->create($data);

        $this->assertDatabaseHas($table, $data);
    }

    abstract protected function model(): Model;

}
