<?php

use App\Company;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(Brand::class,5)->create();
        $companies = new Company([
            'name' => "company name",
            'phone' => '012345678',
            'address' => 'company address',
            'message' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.
',

        ]);
        $companies->save();
    }
}
