<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Utility\Hash;

class HashTest extends TestCase
{
    /** @test */
    public function can_generate_salt_null() {

        $salt = new Hash;
        $lenght = 0;

        $result = $salt->generateSalt($lenght);

        $this->assertEquals( "" ,$result);

    }

    /** @test */
     public function can_generate_salt_negative_lenght() {

        $salt = new Hash;
        $lenght = -3;

        $result = $salt->generateSalt($lenght);
    
        $this->assertEquals( "" , $result);
    }

    /** @test */
     public function can_generate_salt_decimal_lenght() {

        $salt = new Hash;
        $lenght = 1.7;

        $result = $salt->generateSalt($lenght);
    
        $this->assertEquals( 2 , strlen($result));
    }

    /** @test */
     public function can_generate_salt_random_lenght() {

        $salt = new Hash;
        $lenght = random_int(0,200);

        $result = $salt->generateSalt($lenght);
    
        $this->assertEquals( $lenght , strlen($result));
    }

    /** @test */
    public function can_generate_hash_with_two_strings() {

        $hash = new Hash;

        $string = "arthurlabidouille";
        $salt = "by586%dhei89";
        $shouldReturn = hash("sha256", $string . $salt);

        $result = $hash->generate($string, $salt);

        $this->assertEquals( $shouldReturn ,$result);
        
    }

        /** @test */
        public function can_generate_hash_with_null_salt() {

            $hash = new Hash;
    
            $string = "arthurlabidouille";
            $salt = "";
            $shouldReturn = hash("sha256", $string . $salt);
    
            $result = $hash->generate($string, $salt);
    
            $this->assertEquals( $shouldReturn ,$result);
            
        }
}