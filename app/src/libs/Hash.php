<?php

namespace App\Libs;


class Hash
{
    function __construct() {
    }
    
    /** 
     * Tạo chuỗi ký tự đã mã hóa theo kiểu mã hóa sha256
     * từ chuỗi nhập vào và từ khóa SALT
     * @param string data chuỗi nhập vào
     * @param string $salt chuỗi từ khóa, không nên thay đổi
     * @return string chuỗi đã mã hóa
     */
    public function create($data, $salt) {
        $context = hash_init("sha256", HASH_HMAC, $salt);
        hash_update($context, $data);
        return hash_final($context);
    }
    
    /** 
     * Trả về một chuỗi ký tự ngẫu nhiên theo kiểu base64_encode
     * @param no
     * @return string chuỗi mã hóa ngẫu nhiên
     *
     */
    public function random() {
        $result = base64_encode(mcrypt_create_iv("20", MCRYPT_RAND));
        return $result;
    }
}
