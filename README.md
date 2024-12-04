1. download repoositori terlebih dahulu
2. jalankan perintah composer install
3. ketikan perintah cp .env.example .env
4. jalankan perintah php artisan key:generate
5. setelah itu ketikan perintah php artisan migrate untuk membuat database atau import databasenya dan ketiikan perintah php artisan db:seed --class=DatabaseSeeder dan php artisan db:seed --class=UsersTableSeeder untuk menambhkan data dumy
5. ketikkan perintah php artisan serve untuk menjalankan server laravel
6. buka postman untuk menjalankan backendya
7. ketikan url localhoat:8000/api/product atau localhost:8000/api/category untuk melihat data.
8. jika pengguna belum login maka otomotasi akan di minta untuk login di url localhost:8000/api/login atau jika ingin register ketikkan url localhost:8000/register .
9. jika berhasil login pilih header dan masukkan token yang sudah ada ke menu header.
10. jika berhasil maka pengguna bisa mengakses data product atau dana category.
11. jika ingin logout ketikkan perintah localhost:8000/api/logout