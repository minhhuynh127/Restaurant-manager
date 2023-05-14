<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory as Faker;

class TestController extends Controller
{
    function index() {
        // Số tài khoản ngân hàng: $faker->bankAccountNumber
        // Mã số ngân hàng: $faker->bankRoutingNumber
        // Tên ngân hàng: $faker->bank
        // Số thẻ tín dụng: $faker->creditCardNumber
        // Loại thẻ tín dụng: $faker->creditCardType
        // Ngày hết hạn thẻ tín dụng: $faker->creditCardExpirationDateString
        // Mã bảo mật thẻ tín dụng: $faker->creditCardExpirationDateString

        // $faker = Faker::create();
        // dd($faker->bankAccountNumber, $faker->bankRoutingNumber, $faker->creditCardNumber, $faker->creditCardType, $faker->creditCardExpirationDateString, $faker->creditCardExpirationDateString);
        return view('admin.page.login');
    }
}
