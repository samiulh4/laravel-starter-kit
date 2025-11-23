https://chatgpt.com/share/6918c12a-f794-800b-ac14-1f309ad9e079


app/
 └─ Modules/
     └─ FileManager/
         ├─ routes/
         │   └─ web.php
         ├─ resources/
         │   └─ views/
         ├─ database/
         │   └─ migrations/
         ├─ Http/
         │   └─ Controllers/
         ├─ Models/
         └─ Services/
             └─ FileUploadService.php


php artisan db:seed
php artisan db:seed --class=UsersGenderSeeder
php artisan migrate:fresh --seed         

