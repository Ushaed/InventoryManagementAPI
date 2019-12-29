<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(Product::class,50)->create();
        $product = new Product([
            'name' => 'Intel i7 3444 6MB 2.7HZ-3.7HZ',
            'slug' => 'Intel-i7-3444-6mb-2.7hz-3.7hz',
            'category_id' => '1',
            'brand_id' => '3',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();
        $product = new Product([
            'name' => 'Intel i3 3222 6MB 2.7HZ-3.7HZ',
            'slug' => 'Intel-i3-3222-6mb-2.7hz-3.7hz',
            'category_id' => '1',
            'brand_id' => '3',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();
        $product = new Product([
            'name' => 'Intel i5 3777 6MB 2.7HZ-3.7HZ',
            'slug' => 'Intel-i5-3777-6mb-2.7hz-3.7hz',
            'category_id' => '1',
            'brand_id' => '3',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();
        $product = new Product([
            'name' => 'AMD Ryzen 1 6MB 2.7HZ-3.7HZ',
            'slug' => 'amd-ryzen-1-6mb-2.7hz-3.7hz',
            'category_id' => '1',
            'brand_id' => '4',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();
        $product = new Product([
            'name' => 'AMD Ryzen 2 6MB 2.7HZ-3.7HZ',
            'slug' => 'amd-ryzem-2-6mb-2.7hz-3.7hz',
            'category_id' => '1',
            'brand_id' => '4',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Amd Ryzen 3 6MB 2.7HZ-3.7HZ',
            'slug' => 'amd-ryzen-3-6mb-2.7hz-3.7hz',
            'category_id' => '1',
            'brand_id' => '3',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();$product = new Product([
        'name' => 'Sumsung 55inch LED TV',
        'slug' => 'sumsung-55inch-led-tv',
        'category_id' => '2',
        'brand_id' => '1',
        'status' => '1',
        'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
        'buy_price' => '5000',
        'sell_price' => '6000',
    ]);
        $product->save();
        $product = new Product([
            'name' => 'LG 21inch LED Color TV',
            'slug' => 'lg-21inch-led-color-tv',
            'category_id' => '2',
            'brand_id' => '2',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();
        $product = new Product([
            'name' => 'Sumgsung A50',
            'slug' => 'sumgsung-a50',
            'category_id' => '1',
            'brand_id' => '1',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();
        $product = new Product([
            'name' => 'Sumgsung galaxy 8',
            'slug' => 'sumgsung-galaxy-8',
            'category_id' => '1',
            'brand_id' => '3',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();
        $product = new Product([
            'name' => '21inch Cricket Bat',
            'slug' => '21inch-cricket-bat',
            'category_id' => '3',
            'brand_id' => '5',
            'status' => '1',
            'description' => 'HTTP is the underlying communication protocol of World Wide Web. HTTP functions as a request–response protocol in the client–server computing model. HTTP/1.1 is the most common version of HTTP used in modern web browsers and servers. In comparison to early versions of HTTP, this version could implement critical performance optimizations and feature enhancements such as persistent and pipelined connections, chunked transfers, new header fields in request/response body etc. Among them, the following two headers are very notable, because most of the modern improvements to HTTP rely on these two headers.
Keep-Alive header to set policies for long-lived communications between hosts (timeout period and maximum request count to handle per connection)
Upgrade header to switch the connection to an enhanced protocol mode such as HTTP/2.0 (h2,h2c) or Websockets (websocket)
If you are interested in knowing what these really do, I have documented all important information for you in the below article.',
            'buy_price' => '5000',
            'sell_price' => '6000',
        ]);
        $product->save();
    }
}
