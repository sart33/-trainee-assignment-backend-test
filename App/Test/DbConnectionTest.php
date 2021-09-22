<?php


namespace App\Test;


use App\Db\DbConnection;
use App\Model\Ads;
use PHPUnit\Framework\TestCase;
use \PDO;


class DbConnectionTest extends TestCase
{
    private $db_connection;

    protected function setUp():void {
        $this->db_connection = DbConnection::class;
    }

    protected function tearDown():void {
        $this->db_connection = NULL;
    }

    public function getValidinquireIntoDbSelect(): array {
        return [
            ["SELECT title, photo_link_one, price, created_at FROM ads ORDER BY 'price' ASC LIMIT 10, 10"],
            ["SELECT title, photo_link_one, price, created_at FROM ads ORDER BY 'price' ASC LIMIT 10, 20"],
            ["SELECT title, photo_link_one, price, created_at FROM ads"],
        ];

    }
    /**
     * @test
     * @dataProvider getValidinquireIntoDbSelect
     */
    public function detect_an_valid_inquireIntoDb_select($query) {
        $result = DbConnection::inquireIntoDb($query);
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

    public function getInvalidinquireIntoDbSelect(): array {
        return [
            ["SELECT title, photo_link_one, price, created_at  ads ORDER BY 'price' ASC LIMIT 10, 10"],
            ["SELECT title, photo_link_one, price, created_at FROM  ORDER BY 'price' ASC LIMIT 10, 20"],
            ["title, photo_link_one, price, created_at FROM ads"],
        ];

    }
    /**
     * @test
     * @dataProvider getInvalidinquireIntoDbSelect
     */
    public function detect_an_invalid_inquireIntoDb_select($query) {
        $result = DbConnection::inquireIntoDb($query);
        $this->assertFalse($result);
    }


    public function getValidinquireIntoDbInsert(): array {
        return [
            ["INSERT INTO ads (title, announcement_text, photo_link_one, photo_link_two, price) VALUES 
('Метод создания объявления 2.5', 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии (сами фото загружать никуда не требуется), цена. Возвращает ID созданного объявления и код результата (ошибка или успех).', 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg', 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg', '25.24')
 RETURNING ads.id"],

            ["INSERT INTO ads (title, announcement_text, photo_link_one, price) VALUES 
('Метод создания объявления 3', 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии', 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg', '25.24')
 RETURNING ads.id"],

        ];

    }
    /**
     * @test
     * @dataProvider getValidinquireIntoDbInsert
     */
    public function detect_an_valid_inquireIntoDb_insert($query) {
        $result = DbConnection::inquireIntoDb($query);
        $this->assertArrayHasKey('id', $result[0]);
//        $this->assertArrayHasKey('result', $result);

    }

    public function getInvalidinquireIntoDbInsert(): array {
        return [
            ["INTO ads (title, announcement_text, photo_link_one, photo_link_two, price) VALUES 
('Метод создания объявления 2.5', 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии (сами фото загружать никуда не требуется), цена. Возвращает ID созданного объявления и код результата (ошибка или успех).', 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg', 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg', '25.24')
 RETURNING ads.id"],
            ["INSERT INTO (title, announcement_text, photo_link_one, photo_link_two, price) VALUES 
('Метод создания объявления 2.5', 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии (сами фото загружать никуда не требуется), цена. Возвращает ID созданного объявления и код результата (ошибка или успех).', 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg', 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg', '25.24')
 RETURNING ads.id"],
            ["INSERT INTO ads (title, announcement_text, photo_link_one, photo_link_two, price)  
('Метод создания объявления 2.5', 'Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии (сами фото загружать никуда не требуется), цена. Возвращает ID созданного объявления и код результата (ошибка или успех).', 'http://my-microframework.loc/image/5c033e82ca7499082c08632bfa96a3db.jpg', 'http://my-microframework.loc/image/5a33e063cf612ea5d623192adb5cfcd8.jpg', '25.24')
 RETURNING ads.id"],
        ];

    }
    /**
     * @test
     * @dataProvider getInvalidinquireIntoDbInsert
     */
    public function detect_an_invalid_inquireIntoDb_insert($query) {
        $result = DbConnection::inquireIntoDb($query);
        $this->assertFalse($result);
    }
}