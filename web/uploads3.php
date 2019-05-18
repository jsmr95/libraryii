<?php

// This file demonstrates file upload to an S3 bucket. This is for using file upload via a
// file compared to just having the link. If you are doing it via link, refer to this:
// https://gist.github.com/keithweaver/08c1ab13b0cc47d0b8528f4bc318b49a
//
// You must setup your bucket to have the proper permissions. To learn how to do this
// refer to:
// https://github.com/keithweaver/python-aws-s3
// https://www.youtube.com/watch?v=v33Kl-Kx30o

// I will be using composer to install the needed AWS packages.
// The PHP SDK:
// https://github.com/aws/aws-sdk-php
// https://packagist.org/packages/aws/aws-sdk-php
//
// Run:$ composer require aws/aws-sdk-php
require '../vendor/autoload.php';

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

// Connect to AWS

/**
 * Función para subir una imagen a Amazon S3.
 * @return void|S3Exception void si todo va bien, o una excepcion si falla algo.
 */
function uploadImagen()
{
    // AWS Info
    $bucketName = 'imagesjsmr95';
    $IAM_KEY = 'AKIAJV2XC7DOVIQH4YNQ';
    $IAM_SECRET = '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';

    try {
        // You may need to change the region. It will say in the URL when the bucket is open
        // and on creation.
        $s3 = S3Client::factory(
            [
        'credentials' => [
            'key' => $IAM_KEY,
            'secret' => $IAM_SECRET,
        ],
        'version' => 'latest',
        'region' => 'eu-west-2',
    ]
);
    } catch (Exception $e) {
        // We use a die, so if this fails. It stops here. Typically this is a REST call so this would
        // return a json object.
        die('Error: ' . $e->getMessage());
    }

    // For this, I would generate a unqiue random string for the key name. But you can do whatever.
    var_dump($_FILES['Usuarios']['tmp_name']['url_avatar']);

    $keyName = basename($_FILES['Usuarios']['name']['url_avatar']);
    $pathInS3 = 'https://s3.eu-west-2.amazonaws.com/' . $bucketName . '/' . $keyName;
    // Add it to S3
    try {
        // Uploaded:
        $file = $_FILES['Usuarios']['tmp_name']['url_avatar'];
        $s3->putObject(
            [
        'Bucket' => $bucketName,
        'Key' => $keyName,
        'SourceFile' => $file,
        'StorageClass' => 'REDUCED_REDUNDANCY',
    ]
);
    } catch (S3Exception $e) {
        die('Error:' . $e->getMessage());
    } catch (Exception $e) {
        die('Error:' . $e->getMessage());
    }
}

// Now that you have it working, I recommend adding some checks on the files.
// Example: Max size, allowed file types, etc.
