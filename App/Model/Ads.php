<?php

namespace App\Model;

use App\Db\DbConnection;

class Ads
{
    const PAGINATION_COUNT = 10;
    const UNIQUE_TOKEN = '4fa4a176440b71992f089f65eb48e8d5087115538987b3520ce6258d1d995a95';

    protected $tableName;

    public function __construct() {
        $this->tableName = 'ads';
    }


    public function getValidate()
    {
        return [
            'title' => [5, 200],
            'announcementText' => [7, 1000],
            'price' => [1, 8],
            'photoLinkOne' => [1, 3],
            'photoLinkTwo' => [1, 3],
            'photoLinkThree' => [1, 3]

        ];
    }

    public function comeInto($queryInfo) {
        $tableName = $this->tableName;
        $apiKey = $queryInfo['apiKey'];
        $keyValid = $this->validateKey($apiKey);
        if($keyValid === true) {
            if($queryInfo['calledMethod'] === 'getAdsList') {
                if(isset($queryInfo['methodProperties'])) {
                    $methodProperties = $queryInfo['methodProperties'];
                    $adsList = $this->getAdsList($methodProperties);

                    if ($adsList !== false) {
                        for ($i = 0; $i < 10; $i++) {
                            foreach ($adsList[$i] as $key => $item) {
                                unset($adsList[$i]['created_at']);
                            }
                        }
                        return $adsList;
                    } else {
                        return false;
                    }
                } else {
                    echo '"methodProperties" has no values';
                    return false;
                }

        } elseif($queryInfo['calledMethod'] === 'getAdvertisement') {
                if(!empty($queryInfo['nameAdvertisement'])) {
                    $title = $queryInfo['nameAdvertisement'];
                    if(!empty($queryInfo['methodParameter'])) {
                    $parameter = $queryInfo['methodParameter'];
                        $advertisement = $this->getAdvertisement($title, $parameter);
                        return $advertisement;
                } else {
                        $advertisement = $this->getAdvertisement($title);
                        return $advertisement;
                    }
                } else {
                    return false;
                }
        } elseif ($queryInfo['calledMethod'] === 'createAdvertisement') {
                if(!empty($queryInfo['fields']['title'])) {
                    $fields = $queryInfo['fields'];
                    $dataValid = $this->validateFields($fields);
                    if($dataValid !== false) {



                     $fields = '(';
                     $values ='(';

                        foreach ($dataValid as $key => $item) {

                            $fields .= $key . ', ';
                            $values .= "'" . $item . "', ";
                     }
                        $fields = rtrim(rtrim($fields),',') . ')';
                        $values = rtrim(rtrim($values),',') . ')';

                        $sqlInsertData = "INSERT INTO $tableName $fields VALUES $values RETURNING $tableName.id";
                        $insertResult  = DbConnection::inquireIntoDb($sqlInsertData);
                        if ($insertResult !== false) {
                            $id = $insertResult[0]['id'];

                            return ['id' => $id, 'result' => 'true'];
                        }
                    } else {
                        echo 'Fields validation failed';
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function validateKey($apiKey)
    {
        $token = self::UNIQUE_TOKEN;
        if (!empty($apiKey)) {
            if (hash_equals($apiKey, $token)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAdvertisement($title, $parameter = null)
    {
        $tableName = $this->tableName;

        if (isset($parameter) && $parameter === 'fields') {

            $sqlAdvertisement = "SELECT title, announcement_text, price, photo_link_one, photo_link_two, photo_link_three FROM $tableName WHERE title='$title'";
            if(!empty(DbConnection::inquireIntoDb($sqlAdvertisement))) {
                $advData = DbConnection::inquireIntoDb($sqlAdvertisement)[0];
                foreach ($advData as $key => $item) {
                    if (preg_match('#(photo_link_)(.+)#ui', $key, $match) === 1) {
                        if (isset($item) && !empty($item)) {

                        } else {
                            unset($advData[$key]);
                        }


                    }
                }
                return $advData;
            } else {
                echo 'Ads with the same name does not exist';
                return false;
            }
        } else {
            $sqlAdvertisement = "SELECT title, price, photo_link_one FROM $tableName WHERE title='$title'";
            if(!empty(DbConnection::inquireIntoDb($sqlAdvertisement))) {
            $advData = DbConnection::inquireIntoDb($sqlAdvertisement)[0];
            if (is_array($advData) && isset($advData['title'])) {
                return $advData;
            }
        } else {
                echo 'Ads with the same name does not exist';
            return false;
            }
        }

    }

    public function getAdsList($methodProperties) {

        if(isset($methodProperties)) {
            if (isset($methodProperties['pageNumber'])) {
                if(is_numeric($methodProperties['pageNumber'])) {
                    if($methodProperties['pageNumber'] > 0) {
                        $pageNumber = $methodProperties['pageNumber'];
                    } else {
                        echo 'The page number is negative';
                        return false;
                    }
                } else {
                      echo 'The page number is a not numeric';
                    return false;
                }

            } else {
                $pageNumber = 1;
            }
            $sizePage = self::PAGINATION_COUNT;
            // Вычисляем с какого объекта начать выводить
            $offset = ($pageNumber - 1) * $sizePage;
            $tableName = $this->tableName;
            $sql = "SELECT COUNT(*) FROM $tableName";
            $quantity = (DbConnection::inquireIntoDb($sql)[0]['COUNT(*)']);
            $totalPages = ceil($quantity / $sizePage);
            if (isset($methodProperties['sortingBy'])) {
                $sortingBy = $methodProperties['sortingBy'];
                if (isset($methodProperties['ascDesc'])) {
                    if($methodProperties['ascDesc'] === 'asc') {
                        $sqlSelectList = "SELECT title, photo_link_one, price, created_at FROM $tableName ORDER BY $sortingBy ASC LIMIT $offset, $sizePage";

                    } elseif ($methodProperties['ascDesc'] === 'desc') {
                        $sqlSelectList = "SELECT title, photo_link_one, price, created_at FROM $tableName ORDER BY $sortingBy DESC LIMIT $offset, $sizePage";

                    } else {
                        $sqlSelectList = "SELECT title, photo_link_one, price, created_at FROM $tableName ORDER BY $sortingBy DESC LIMIT $offset, $sizePage";
                    }
                } else {
                    $sqlSelectList = "SELECT title, photo_link_one, price, created_at FROM $tableName ORDER BY $sortingBy DESC LIMIT $offset, $sizePage";
                }
            } else {
                $sqlSelectList = "SELECT title, photo_link_one, price, created_at FROM $tableName ORDER BY created_at DESC LIMIT $offset, $sizePage";
            }

            return DbConnection::inquireIntoDb($sqlSelectList);

        } else {
            return false;
        }


    }

    public function validateFields($fields) {
       if(isset($fields['announcementText']) && isset($fields['photoLinkOne']) && isset($fields['price']) && isset($fields['title'])) {

           $limitArr = $this->getValidate();
           $i = 0;
           foreach ($fields as $key => $item) {
               $length = strlen($item);


               if (!isset($limitArr[$key])) {
                   echo 'Undefined field <br>';
                   return false;

               } else {
                   $min = $limitArr[$key][0];

                   $max = $limitArr[$key][1];
                   if (preg_match('#(photoLink)(.+)#ui', $key, $matches) === 1) {
                       $i++;

                       if ($i >= $min && $i <= $max && $length >= 3 && $length <= 128) {
//                       if (is_readable($item)) {
//
//                       } else {
//                           echo 'Validate ' . $key . ' - error. File is not follow or not readable';
//                           return false;
//                       }

                       } else {
                           echo 'Validate ' . $key . 'quantity - error: ' . 'quantity is ' . "'" . $i . "'.";
                           return false;
                       }

                   } else {

                       if ($length >= $min && $length <= $max) {

                           if (is_numeric($item)) {
                               if (($item >= 0)) {

                               } else {
                                   echo 'Validate ' . $key . ' - error: ' . $key . ' is ' . "'" . $item . "'.";
                                   return false;
                               }
                           }
                       } else {
                           echo 'Validate ' . $key . ' - error: ' . $key . ' is ' . "'" . $item . "'.";
                           return false;
                       }

                   }

               }

               $newKeys = [];
               foreach ($fields as $key => $item) {
                   if (preg_match('#^(\w+?)([A-Z])([a-z]+)([A-Z])*([a-z]*?)$#', $key, $matches) === 1) {
                       if (empty($matches[4]) && empty($matches[5])) {
                           $newKeys[$matches[1] . '_' . strtolower($matches[2]) . $matches[3] . $matches[4] . $matches[5]] = $item;
                       } else {
                           $newKeys[$matches[1] . '_' . strtolower($matches[2]) . $matches[3] . '_' . strtolower($matches[4]) . $matches[5]] = $item;
                       }

                   } else {
                       $newKeys[$key] = $item;
                   }
               }

               $keyArr = $this->showColumnsKeys($this->tableName);
               $resultArr = [];
               foreach ($newKeys as $key => $item) {
                   if (!isset($keyArr[$key])) {
                       echo 'There are no such fields in the database';
                       return false;
                   }
               }
               foreach ($keyArr as $key => $item) {
                   if (isset($newKeys[$key])) {
                       $resultArr[$key] = $newKeys[$key];
                   }
               }
           }
           return $resultArr;

       } else {
           return false;
       }

    }

    public function showColumnsKeys($table)
    {
        $tableColumns = [];
        $query = "SHOW COLUMNS FROM $table";
        if (!empty(DbConnection::inquireIntoDb($query))) {
            $res = DbConnection::inquireIntoDb($query);
            foreach ($res as $item) {
                if ($item['Key'] === 'PRI') {
                } else {
                    $tableColumns[$item['Field']] = 'field';
                }
            }
            return $tableColumns;
        } else {
            return false;
        }
    }
}