<?php

namespace App\Test;

use App\Model\Ads;

use PHPUnit\Framework\TestCase;


class AdsTest extends TestCase
{
    private $ads;

    protected function setUp():void {
        $this->ads = new Ads();
    }

    protected function tearDown():void {
        $this->ads = NULL;
    }

    public function getValidValidateKey(): array {
        return [
            ['4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95'],
        ];

    }

    /**
     * @depends detect_an_valid_comeInto_createAdvertisement
     * @depends detect_an_valid_comeInto_getAdvertisement_fields
     * @depends detect_an_valid_comeInto_getAdvertisement
     * @test
     * @dataProvider getValidValidateKey
     */
    public function detect_an_valid_validateKey_method($apiKey) {
        $result = $this->ads->validateKey($apiKey);
        $this->assertTrue($result);
    }

    public function getInvalidValidateKey(): array {
        return [
            [''],
            [' 4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95 '],
            ['4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a96'],
        ];

    }
    /**
     * @test
     * @dataProvider getInvalidValidateKey
     */
    public function detect_an_invalid_validateKey_method($apiKey) {
        $result = $this->ads->validateKey($apiKey);
        $this->assertFalse($result);
    }


    public function getValidGetAdsListPagination(): array {
        return [
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '1']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '2']],
            [['pageNumber' => '1']],
            [['pageNumber' => '2']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc']],
            [''],
        ];

    }

    /**
     * @test
     * @dataProvider getValidGetAdsListPagination
     */
    public function detect_an_valid_getAdsList_pagination_method($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertArrayHasKey(0, $result);
        $this->assertArrayHasKey(1, $result);
        $this->assertArrayHasKey(2, $result);
        $this->assertArrayHasKey(3, $result);
        $this->assertArrayHasKey(4, $result);



    }

    public function getInvalidGetAdsListPagination(): array {
        return [
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '0']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '-1']],
            [['pageNumber' => '0']],
            [['pageNumber' => '-1']],
            [['pageNumber' => '100000000000000000000000000000']],
            [['pageNumber' => 'abc']],
            [['pageNumber' => ['1']]],
            [['pageNumber' => '']],

        ];

    }

    /**
     * @test
     * @dataProvider getInvalidGetAdsListPagination
     */
    public function detect_an_invalid_getAdsList_pagination_method($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertFalse($result);
//        $this->assertArrayHasKey(1, $result);
//        $this->assertArrayHasKey(2, $result);
//        $this->assertArrayHasKey(3, $result);
//        $this->assertArrayHasKey(4, $result);



    }


    public function getValidGetAdsListCount(): array {
        return [
        [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '1']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '2']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '3']],
        [['sortingBy' => 'price', 'ascDesc' => 'desc']],
        [''],
];

    }

    /**
     * @test
     * @dataProvider getValidGetAdsListCount
     */
    public function detect_an_valid_getAdsList_method($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertArrayHasKey(0, $result);
        $this->assertArrayHasKey(1, $result);
        $this->assertArrayHasKey(2, $result);
        $this->assertArrayHasKey(3, $result);
        $this->assertArrayHasKey(4, $result);
        $this->assertArrayHasKey(4, $result);
        $this->assertArrayHasKey(5, $result);
        $this->assertArrayHasKey(7, $result);
        $this->assertArrayHasKey(8, $result);
        $this->assertArrayHasKey(9, $result);


    }

    public function getValidGetAdsListFields(): array {
        return [
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '1']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc']],
            [['sortingBy' => 'price']],
            [['']],
            [''],
        ];

    }

    /**
     * @test
     * @dataProvider getValidGetAdsListFields
     */
    public function detect_an_valid_getAdsList_fields_method($postFields) {
        $result = $this->ads->getAdsList($postFields);


        $this->assertArrayHasKey('title', $result[0]);
        $this->assertArrayHasKey('price', $result[0]);
        $this->assertArrayHasKey('photo_link_one', $result[0]);
        $this->assertArrayHasKey('title', $result[4]);
        $this->assertArrayHasKey('price', $result[4]);
        $this->assertArrayHasKey('photo_link_one', $result[4]);
        $this->assertArrayHasKey('title', $result[9]);
        $this->assertArrayHasKey('price', $result[9]);
        $this->assertArrayHasKey('photo_link_one', $result[9]);
    }



    public function getValidGetAdsListSortPriceAsc(): array {
        return [
            [['sortingBy' => 'price', 'ascDesc' => 'asc', 'pageNumber' => '1']],
            [['sortingBy' => 'price', 'ascDesc' => 'asc', 'pageNumber' => '2']],
            [['sortingBy' => 'price', 'ascDesc' => 'asc', 'pageNumber' => '3']],

        ];

    }

    /**
     * @test
     * @dataProvider getValidGetAdsListSortPriceAsc
     */
    public function detect_an_valid_getAdsListSortPriceAsc_method($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertLessThanOrEqual($result[9]['price'], $result[8]['price']);
        $this->assertLessThanOrEqual($result[8]['price'], $result[7]['price']);
        $this->assertLessThanOrEqual($result[7]['price'], $result[6]['price']);
        $this->assertLessThanOrEqual($result[6]['price'], $result[5]['price']);
        $this->assertLessThanOrEqual($result[5]['price'], $result[4]['price']);
        $this->assertLessThanOrEqual($result[4]['price'], $result[3]['price']);
        $this->assertLessThanOrEqual($result[3]['price'], $result[2]['price']);
        $this->assertLessThanOrEqual($result[2]['price'], $result[1]['price']);
        $this->assertLessThanOrEqual($result[1]['price'], $result[0]['price']);
    }

    public function getValidGetAdsListSortPriceDesc(): array {
        return [
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '1']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '2']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '3']],

        ];

    }

    /**
     * @test
     * @dataProvider getValidGetAdsListSortPriceDesc
     */
    public function detect_an_valid_getAdsListSortPriceDesc_method($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertLessThanOrEqual($result[8]['price'], $result[9]['price']);
        $this->assertLessThanOrEqual($result[7]['price'], $result[8]['price']);
        $this->assertLessThanOrEqual($result[6]['price'], $result[7]['price']);
        $this->assertLessThanOrEqual($result[5]['price'], $result[6]['price']);
        $this->assertLessThanOrEqual($result[4]['price'], $result[5]['price']);
        $this->assertLessThanOrEqual($result[3]['price'], $result[4]['price']);
        $this->assertLessThanOrEqual($result[2]['price'], $result[3]['price']);
        $this->assertLessThanOrEqual($result[1]['price'], $result[2]['price']);
        $this->assertLessThanOrEqual($result[0]['price'], $result[1]['price']);

    }



    public function getInvalidGetAdsListSortPriceDesc(): array {
        return [
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '1']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '2']],
            [['sortingBy' => 'price', 'ascDesc' => 'desc', 'pageNumber' => '3']],
        ];

    }
    /**
     * @test
     * @dataProvider getInvalidGetAdsListSortPriceDesc
     */
    public function detect_an_invalid_getAdsList_method_sort_price_desc($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertGreaterThanOrEqual($result[9]['price'], $result[8]['price']);
        $this->assertGreaterThanOrEqual($result[8]['price'], $result[7]['price']);
        $this->assertGreaterThanOrEqual($result[7]['price'], $result[6]['price']);
        $this->assertGreaterThanOrEqual($result[6]['price'], $result[5]['price']);
        $this->assertGreaterThanOrEqual($result[5]['price'], $result[4]['price']);
        $this->assertGreaterThanOrEqual($result[4]['price'], $result[3]['price']);
        $this->assertGreaterThanOrEqual($result[3]['price'], $result[2]['price']);
        $this->assertGreaterThanOrEqual($result[2]['price'], $result[1]['price']);
        $this->assertGreaterThanOrEqual($result[1]['price'], $result[0]['price']);
    }


    public function getValidGetAdsListSortCreatedAtAsc(): array {
        return [
            [['sortingBy' => 'created_at', 'ascDesc' => 'asc', 'pageNumber' => '1']],
            [['sortingBy' => 'created_at', 'ascDesc' => 'asc', 'pageNumber' => '2']],
            [['sortingBy' => 'created_at', 'ascDesc' => 'asc', 'pageNumber' => '3']],

        ];

    }

    /**
     * @test
     * @dataProvider getValidGetAdsListSortCreatedAtAsc
     */
    public function detect_an_valid_getAdsListSortCreatedAtAsc_method($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertLessThanOrEqual($result[9]['created_at'], $result[8]['created_at']);
        $this->assertLessThanOrEqual($result[8]['created_at'], $result[7]['created_at']);
        $this->assertLessThanOrEqual($result[7]['created_at'], $result[6]['created_at']);
        $this->assertLessThanOrEqual($result[6]['created_at'], $result[5]['created_at']);
        $this->assertLessThanOrEqual($result[5]['created_at'], $result[4]['created_at']);
        $this->assertLessThanOrEqual($result[4]['created_at'], $result[3]['created_at']);
        $this->assertLessThanOrEqual($result[3]['created_at'], $result[2]['created_at']);
        $this->assertLessThanOrEqual($result[2]['created_at'], $result[1]['created_at']);
        $this->assertLessThanOrEqual($result[1]['created_at'], $result[0]['created_at']);
    }


    public function getValidGetAdsListSortCreatedAtDesc(): array {
        return [
            [['sortingBy' => 'created_at', 'ascDesc' => 'desc', 'pageNumber' => '1']],
            [['sortingBy' => 'created_at', 'ascDesc' => 'desc', 'pageNumber' => '2']],
            [['sortingBy' => 'created_at', 'ascDesc' => 'desc', 'pageNumber' => '3']],

        ];

    }

    /**
     * @test
     * @dataProvider getValidGetAdsListSortCreatedAtDesc
     */
    public function detect_an_valid_getAdsListSortCreatedAtDesc_method($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertLessThanOrEqual($result[8]['created_at'], $result[9]['created_at']);
        $this->assertLessThanOrEqual($result[7]['created_at'], $result[8]['created_at']);
        $this->assertLessThanOrEqual($result[6]['created_at'], $result[7]['created_at']);
        $this->assertLessThanOrEqual($result[5]['created_at'], $result[6]['created_at']);
        $this->assertLessThanOrEqual($result[4]['created_at'], $result[5]['created_at']);
        $this->assertLessThanOrEqual($result[3]['created_at'], $result[4]['created_at']);
        $this->assertLessThanOrEqual($result[2]['created_at'], $result[3]['created_at']);
        $this->assertLessThanOrEqual($result[1]['created_at'], $result[2]['created_at']);
        $this->assertLessThanOrEqual($result[0]['created_at'], $result[1]['created_at']);

    }



    public function getInvalidGetAdsListSortCreatedAtAsc(): array {
        return [
            [['sortingBy' => 'created_at', 'ascDesc' => 'false', 'pageNumber' => '1']],
            [['sortingBy' => 'created_at', 'ascDesc' => 'false', 'pageNumber' => '2']],
            [['sortingBy' => 'created_at', 'ascDesc' => 'false', 'pageNumber' => '3']],

        ];

    }

    /**
     * @test
     * @dataProvider getInvalidGetAdsListSortCreatedAtAsc
     */
    public function detect_an_invalid_getAdsListSortCreatedAtAsc_method($postFields) {
        $result = $this->ads->getAdsList($postFields);
        $this->assertGreaterThanOrEqual($result[9]['created_at'], $result[8]['created_at']);
        $this->assertGreaterThanOrEqual($result[8]['created_at'], $result[7]['created_at']);
        $this->assertGreaterThanOrEqual($result[7]['created_at'], $result[6]['created_at']);
        $this->assertGreaterThanOrEqual($result[6]['created_at'], $result[5]['created_at']);
        $this->assertGreaterThanOrEqual($result[5]['created_at'], $result[4]['created_at']);
        $this->assertGreaterThanOrEqual($result[4]['created_at'], $result[3]['created_at']);
        $this->assertGreaterThanOrEqual($result[3]['created_at'], $result[2]['created_at']);
        $this->assertGreaterThanOrEqual($result[2]['created_at'], $result[1]['created_at']);
        $this->assertGreaterThanOrEqual($result[1]['created_at'], $result[0]['created_at']);
    }


    public function getInvalidGetAdvertisement(): array {
        return [
            ['title' => ''],
            ['title' => 'a'],

        ];

    }

    /**
     * @test
     * @dataProvider getInvalidGetAdvertisement
     */
    public function detect_an_invalid_getAdvertisement_method($title) {
        $result = $this->ads->getAdvertisement($title);
        $this->assertFalse($result);

    }

    public function getInvalidGetAdvertisementWithParam(): array {
        return [

            ['title' => 'a', 'parameter' => 'fields'],
            ['title' => '', 'parameter' => 'fields']


        ];

    }

    /**
     * @test
     * @dataProvider getInvalidGetAdvertisementWithParam
     */
    public function detect_an_invalid_getAdvertisement_method_withParam($title) {
        $result = $this->ads->getAdvertisement($title);
        $this->assertFalse($result);

    }

    public function getValidGetAdvertisementWithParam(): array {
        return [
            ['title' => 'Метод создания объявления 2.1', 'parameter' => 'fields']

        ];

    }

    /**
     * @test
     * @dataProvider getValidGetAdvertisementWithParam
     */
    public function detect_an_valid_getAdvertisement_with_param_method($title, $parameter) {
        $result = $this->ads->getAdvertisement($title, $parameter);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('announcement_text', $result);
        $this->assertArrayHasKey('photo_link_one', $result);
        $this->assertArrayHasKey('photo_link_two', $result);
        $this->assertArrayHasKey('price', $result);

    }

    public function getValidGetAdvertisementWithoutParam(): array {
        return [
            ['title' => 'Метод создания объявления 2.1']

        ];

    }

    /**
     * @test
     * @dataProvider getValidGetAdvertisementWithoutParam
     */
    public function detect_an_valid_getAdvertisement_without_param_method($title) {
        $result = $this->ads->getAdvertisement($title);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('photo_link_one', $result);
        $this->assertArrayHasKey('price', $result);


    }

    public function getInvalidShowColumnsKeys(): array {
        return [

            ['no_ads'],
            [''],

        ];

    }

    /**
     * @test
     * @dataProvider getInvalidShowColumnsKeys
     */
    public function detect_an_invalid_showColumnsKeys($table) {
        $result = $this->ads->showColumnsKeys($table);
        $this->assertFalse($result);

    }

    public function getValidShowColumnsKeys(): array {
        return [
            ['ads']

        ];

    }

    /**
     * @test
     * @dataProvider getValidShowColumnsKeys
     */
    public function detect_an_valid_showColumnsKeys($table) {
        $result = $this->ads->showColumnsKeys($table);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('announcement_text', $result);
        $this->assertArrayHasKey(	'photo_link_one', $result);
        $this->assertArrayHasKey('price', $result);


    }

    
    public function getInvalidValidateFields(): array {
        return [

        [[
            'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'price' => '15.20',
            'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],

        [['title' => '',
            'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'price' => '15.20',
            'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],


        [['title' => 'M',
            'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'price' => '15.20',
            'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],


    [['title' => 'Ме',
     'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
     'price' => '15.20',
     'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],


    [['title' => 'Метод создания объявления 2.2',
     'price' => '15.20',
     'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],

    [['title' => 'Метод создания объявления 2.2',
     'announcementText' => '',
     'price' => '15.20',
     'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],

    [['title' => 'Метод создания объявления 2.2',
     'announcementText' => 'П',
     'price' => '15.20',
     'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],

    [['title' => 'Метод создания объявления 2.2',
     'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
     'price' => '',
     'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],

    [['title' => 'Метод создания объявления 2.2',
     'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
     'price' => '-1',
     'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg']],

    [['title' => 'Метод создания объявления 2.2',
     'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
     'price' => '15.20']],

    [['title' => 'Метод создания объявления 2.2',
     'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
     'price' => '15.20',
     'photoLinkOne' => '']],

        [['title' => 'Метод создания объявления 2.2',
            'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'price' => '15.20',
            'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
            'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg',
            'photoLinkThree' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
            'photoLinkFour' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',]],


        [['title' => 'Метод создания объявления 2.2',
            'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'priceOne' => '15.20',
            'priceTwo' => '15.20',
            'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
            'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg']],


        [['title' => 'Метод создания объявления 2.2',
            'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
            'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg']],



        [['titles' => 'Метод создания объявления 2.2',
            'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'price' => '15.20']],



        [['title' => 'Метод создания объявления 2.2',
            'Text' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'price' => '15.20',
            'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
            'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg']],



        [['title' => 'Метод создания объявления 2.2',
            'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'otherText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
            'price' => '15.20',
            'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
            'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg']],






 ];
    }

    /**
     * @test
     * @dataProvider getInvalidValidateFields
     */
    public function detect_an_invalid_validateFields($fields) {
        $result = $this->ads->validateFields($fields);
        $this->assertFalse($result);

    }

    public function getValidValidateFields(): array {
        return [
                [['title' => 'Метод создания объявления 2.2',
               'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
               'price' => '15.20',
               'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
               'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg']],

            [['title' => 'Метод создания объявления 2.2',
               'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
               'price' => '15.20',
               'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
               'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg']],

            [['photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
                'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg',
                'title' => 'Метод создания объявления 2.2',
               'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
               'price' => '15.20']],

            [[ 'price' => '15.20',
               'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии',
               'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
               'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg',
                'title' => 'Метод создания объявления 2.2']]

        ];

    }

    /**
     * @test
     * @dataProvider getValidValidateFields
     */
    public function detect_an_valid_validateFields($fields) {
        $result = $this->ads->validateFields($fields);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('announcement_text', $result);
        $this->assertArrayHasKey('price', $result);
        $this->assertArrayHasKey('photo_link_one', $result);
        $this->assertArrayHasKey('photo_link_two', $result);

    }


    public function getInvalidcomeIntoCreateAdvertisement(): array {
        return [

            [
                ['apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                    'calledMethod' =>'createAdvertisement',

                ]]

        ];

    }

    /**
     * @test
     * @dataProvider getInvalidcomeIntoCreateAdvertisement
     */
    public function detect_an_invalid_comeInto_createAdvertisement($postFields) {
        $result = $this->ads->comeInto($postFields);
        $this->assertFalse($result);

    }



    public function getValidcomeIntoCreateAdvertisement(): array {
        return [
            [
                ['apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                'calledMethod' =>'createAdvertisement',
                'fields' => [
                    'photoLinkOne' => 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg',
                    'title' => 'Метод создания объявления 2.5',
                    'announcementText' => 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии (сами фото загружать никуда не требуется), цена. Возвращает ID созданного объявления и код результата (ошибка или успех).',
                    'price' => '25.24',
                    'photoLinkTwo' => 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg'
    ]
                ]]
        ];

    }

    /**
     * @test
     * @dataProvider getValidcomeIntoCreateAdvertisement
     */
    public function detect_an_valid_comeInto_createAdvertisement($postFields) {
        $result = $this->ads->comeInto($postFields);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('result', $result);



    }


    public function getInvalidcomeIntoGetAdvertisement(): array {
        return [

            [[
                    'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                    'calledMethod' =>'getAdvertisement',
                    'name' => 'Метод создания объявления 2.1',
                    'methodParameter' =>'not-fields',

                ]],


            [[
                    'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                    'calledMethod' =>'getAdvertisement',
                    'nameAdvertisement' => '111',


                ]],

            [[
                    'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                    'calledMethod' =>'getAdvertisement',
                    'nameAdvertisement' => '',
                    'methodParameter' =>'fields',

                ]],

            [[
                    'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                    'calledMethod' =>'getAdvertisement',
                    'nameAdvertisement' => '',


                ]],

            [[
                    'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                    'calledMethod' =>'getAdvertisement',
                    'nameAdvertisement' => null,

                ]],


        ];

    }

    /**
     * @test
     * @dataProvider getInvalidcomeIntoGetAdvertisement
     */
    public function detect_an_invalid_comeInto_getAdvertisement($postFields) {
        $result = $this->ads->comeInto($postFields);
        $this->assertFalse($result);

    }



    public function getValidcomeIntoGetAdvertisement(): array {
        return [
            [
                [
                    'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                    'calledMethod' =>'getAdvertisement',
                    'nameAdvertisement' => 'Метод создания объявления 2.1',
                    'methodParameter' =>'fields',

                ]]
        ];

    }

    /**
     * @test
     * @dataProvider getValidcomeIntoGetAdvertisement
     */
    public function detect_an_valid_comeInto_getAdvertisement($postFields) {
        $result = $this->ads->comeInto($postFields);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('price', $result);
        $this->assertArrayHasKey('photo_link_one', $result);



    }

    public function getValidcomeIntoGetAdvertisementFields(): array {
        return [
            [
                [
                    'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                    'calledMethod' =>'getAdvertisement',
                    'nameAdvertisement' => 'Метод создания объявления 2.1',
                    'methodParameter' =>'fields',

                ]]
        ];

    }

    /**
     * @test
     * @dataProvider getValidcomeIntoGetAdvertisementFields
     */
    public function detect_an_valid_comeInto_getAdvertisement_fields($postFields) {
        $result = $this->ads->comeInto($postFields);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('announcement_text', $result);
        $this->assertArrayHasKey('price', $result);
        $this->assertArrayHasKey('photo_link_one', $result);
        $this->assertArrayHasKey('photo_link_two', $result);



    }



    public function getInvalidcomeIntoGetAdsList(): array {
        return [

            [[
                'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                'calledMethod' =>'getAdsList',
                'method' => '0000',
            ]],
            [[
                'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                'calledMethod' =>'getAdsList',
                'methodProperties' => null

            ]],
            [[
                'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                'calledMethod' =>'getAdsList',

            ]],


        ];

    }

    /**
     * @test
     * @dataProvider getInvalidcomeIntoGetAdsList
     */
    public function detect_an_invalid_comeInto_getAdsList($postFields) {
        $result = $this->ads->comeInto($postFields);
        $this->assertFalse($result);

    }



    public function getValidcomeIntoGetAdsList(): array {
        return [
            [[
                'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                'calledMethod' =>'getAdsList',
                'methodProperties' => [
                    'sortingBy' => 'created_at',
                    'ascDesc' => 'asc',
                    'pageNumber' => '2'
    ]
                ]],
            [[
                'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                'calledMethod' =>'getAdsList',
                'methodProperties' => [
                    'sortingBy' => 'created_at',
                    'ascDesc' => 'asc',
                    'pageNumber' => '1'
    ]
                ]],
            [[
                'apiKey' =>'4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95',
                'calledMethod' =>'getAdsList',
                'methodProperties' => [
                    'sortingBy' => 'created_at',
                    'pageNumber' => '1'
    ]
                ]],
            ];

    }

    /**
     * @test
     * @dataProvider getValidcomeIntoGetAdsList
     */
    public function detect_an_valid_comeInto_getAdsList($postFields) {
        $result = $this->ads->comeInto($postFields);
        $this->assertArrayHasKey('title', $result[0]);
        $this->assertArrayHasKey('price', $result[0]);
        $this->assertArrayHasKey('photo_link_one', $result[0]);
        $this->assertArrayHasKey('title', $result[4]);
        $this->assertArrayHasKey('price', $result[4]);
        $this->assertArrayHasKey('photo_link_one', $result[4]);
        $this->assertArrayHasKey('title', $result[9]);
        $this->assertArrayHasKey('price', $result[9]);
        $this->assertArrayHasKey('photo_link_one', $result[9]);




    }



}