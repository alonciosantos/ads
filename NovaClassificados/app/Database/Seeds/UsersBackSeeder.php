<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersBackSeeder extends Seeder
{
    public function run()
    {
        try {
            $this->db->transStart();

            foreach (self::Users() as $user) {
                $this->db->table('users')->insert($user);
            }

            //print_r(self::subscriptions());
           // exit;
            $this->db->transComplete();

            echo 'Users criadas com sucesso!';
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            print $th;
        }
    }

    private static function Users(): array
    {
        $users = array(
            array(
                'id' => '2',
                'email' => 'alessandra30@escobar.info',
                'username' => 'cristovao.ferraz',
                'password' => '$2y$10$YJa1cBHK4.XH1MuhtXDMmepBRWzZS2swepob6Q9X.fvleyXFUDcW2',
                'email_verified_at' => '2022-08-21 12:30:37',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Dr. Matias Giovane Rios',
                'last_name' => 'Feliciano',
                'cpf' => '646.330.535-90',
                'birth' => '2022-08-21',
                'phone' => '(28) 97741-6541',

                'display_phone' => '1'
            ),
            array(
                'id' => '3',
                'email' => 'mascarenhas.mirella@carmona.net',
                'username' => 'gisele.branco',
                'password' => '$2y$10$gwvyEweobM7DtpX0aYegtOI.8EVNitIi3GAtDxXrPQOtUbli9Zipi',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Marina Galvão Neto',
                'last_name' => 'Prado',
                'cpf' => '489.504.695-88',
                'birth' => '2022-08-21',
                'phone' => '(94) 99361-0210',
                'display_phone' => '1'
            ),
            array(
                'id' => '4',
                'email' => 'eliane.ferraz@gmail.com',
                'username' => 'luis.grego',
                'password' => '$2y$10$vU9KtPEyalJ8XsO0v0ZRvux2ai7JSengN22woW.aWmaCvqkPlPMiy',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Andréa Ingrid Santiago Neto',
                'last_name' => 'Bonilha',
                'cpf' => '638.164.078-20',
                'birth' => '2022-08-21',
                'phone' => '(77) 98445-9063',
                'display_phone' => '0'
            ),
            array(
                'id' => '5', 'email' => 'amelia06@gmail.com',
                'username' => 'bittencourt.alessandra',
                'password' => '$2y$10$AxBVRsnyhuAg5SSUhE5A6Op4VTTgVjEpHN1.oqd/UMprMSiPDvDAq',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Sra. Raissa Galvão Saraiva Jr.',
                'last_name' => 'Paes',
                'cpf' => '484.413.009-92',

                'birth' => '2022-08-21',
                'phone' => '(54) 98156-3077',
                'display_phone' => '0'
            ),
            array(
                'id' => '6',
                'email' => 'wellington93@hotmail.com',
                'username' => 'benites.stephanie',
                'password' => '$2y$10$ygoxueLHmrse6gBXL19/0.LD3Q02AF4IMr0MM4d9mYzxSg43LQDO2',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Isabella de Arruda Filho',
                'last_name' => 'Ferraz',
                'cpf' => '785.836.178-30',
                'birth' => '2022-08-21',
                'phone' => '(13) 98299-2599',
                'display_phone' => '1'
            ),
            array(
                'id' => '7',
                'email' => 'padilha.nadia@hotmail.com',
                'username' => 'anita.bezerra',
                'password' => '$2y$10$IIXUGuJ6ivHjB3VMRhc5TOYUrhPPzugb5k.gOKx/i5aMsFZ0gCEUe',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Bruno de Arruda Jr.',
                'last_name' => 'Barreto',
                'cpf' => '261.556.093-06',
                'birth' => '2022-08-21',
                'phone' => '(86) 92032-3862',
                'display_phone' => '0'
            ),
            array(
                'id' => '8',
                'email' => 'rivera.irene@esteves.org',
                'username' => 'bdelgado',
                'password' => '$2y$10$vnuBZcJ6MmkItHZ9hJx0p.p.mk3RHoS2LjVXAOhJzgtTTJT8XsV7u',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Elias Benício Valentin Sobrinh',
                'last_name' => 'Soto',
                'cpf' => '204.457.550-75',
                'birth' => '2022-08-21',
                'phone' => '(88) 96108-7064',
                'display_phone' => '0'
            ),
            array(
                'id' => '9',
                'email' => 'pena.regiane@gmail.com',
                'username' => 'alexandre.serna',
                'password' => '$2y$10$X9Zvwpxn3gbf.ks52sZI.eYIyGm8kN46hzOoxMBVT3PcNaJPVlx2a',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Marina Rosana Rangel',
                'last_name' => 'Paes',
                'cpf' => '603.815.502-30',
                'birth' => '2022-08-21',
                'phone' => '(88) 99793-5011',
                'display_phone' => '0'
            ),
            array(
                'id' => '10',
                'email' => 'kevin.fidalgo@dacruz.org',
                'username' => 'csantana',
                'password' => '$2y$10$nOzgWbA8/9E12RHoPLShaOZWWONprqrWWPyoAKqlCZNT6tp7.3zmC',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Dr. Vicente Delgado Neto',
                'last_name' => 'Quintana',
                'cpf' => '761.985.778-80',
                'birth' => '2022-08-21',
                'phone' => '(12) 97914-8915',
                'display_phone' => '1'
            ),
            array(
                'id' => '11',
                'email' => 'andres.rodrigues@gil.com',
                'username' => 'william.prado',
                'password' => '$2y$10$famnsYM0FHfyMeOPd0GBjOs.ygPygkxqVgeSmZJriVOmRL0ahOLUG',
                'email_verified_at' => '2022-08-21 12:30:38',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42', 'deleted_at' => NULL,
                'name' => 'Sr. Miguel Simão Cervantes',
                'last_name' => 'Carmona',
                'cpf' => '977.056.717-51',
                'birth' => '2022-08-21',
                'phone' => '(18) 97637-8147',
                'display_phone' => '1'
            ),
            array(
                'id' => '12',
                'email' => 'pedro.paz@saito.com',
                'username' => 'yuri94',
                'password' => '$2y$10$kHRWvlPgIg681bsU9Kwheu8aCJHy9O/nGxXpQCjiXdCD/GXS1OKVC',
                'email_verified_at' => '2022-08-21 12:30:39',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Sr. Erik Alessandro Rosa Neto',
                'last_name' => 'Balestero',
                'cpf' => '535.371.864-01',
                'birth' => '2022-08-21',
                'phone' => '(18) 96482-7719',
                'display_phone' => '0'
            ),
            array(
                'id' => '13',
                'email' => 'eduarda66@queiros.com',
                'username' => 'tmarinho',
                'password' => '$2y$10$B42N.a4fq8eAx.jl99S3g.TjQz7fXcSkcMM4hcvzxU.uwQ6NdVr5.',
                'email_verified_at' => '2022-08-21 12:30:39',
                'remember_token' => NULL,
                'created_at' => '2022-08-21 12:31:42',
                'updated_at' => '2022-08-21 12:31:42',
                'deleted_at' => NULL,
                'name' => 'Dr. Reinaldo Teobaldo Rezende ',
                'last_name' => 'Madeira',
                'cpf' => '492.460.428-32',
                'birth' => '2022-08-21',
                'phone' => '(42) 97132-1013',
                'display_phone' => '1'
            )

        );
        return $users;
    }
}
