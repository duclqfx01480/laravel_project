<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// FYI 41@ 08:40
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo ra user
        // UserSeeder ở đây không tạo user như cách TagSeeder tạo ra tag từ mảng dữ liệu
        // UserSeeder sẽ dùng factories (có thể hiểu factories như là blueprint để fill model)
        // UserFactory sẽ tạo ra một random user mỗi lần gọi đến no
        // Nếu lặp n lần thì nó sẽ tạo ra ngẫu nhiên n user

        \App\Models\User::factory(100)->create()
            // Với mỗi user do UserFactory tạo ra (UserSeeder seed)
            // sẽ tạo ra vài hobbies (ngẫu nhiên từ 1 đến 8)
            // ??? Tại sao lại là 8 => vì chúng ta seed 8 tag trong bảng tags (để đồng bộ với dữ liệu seed)
            // truyền vào closure function tham số $user vì ở trên đang dùng Model User nên sẽ tạo ra $user
            ->each(function($user){
                \App\Models\Hobby::factory(rand(1,8))->create(
                    // Thêm user_id cho mỗi hobby
                    [
                        'user_id' => $user->id
                    ]
                )
                // FYI 41@ 08:40
                // với mỗi create hobby, sẽ thực hiện thêm hobby_id vào bảng hobby_tag
                ->each(function($hobby){
                    $tag_ids = range(1,8); // mảng id của tag từ 1 tới 8 vì ta tạo ra 8 tags
                    shuffle($tag_ids); // có mảng các tag_id từ 1 đến 8 nhưng thứ tự ngẫu nhiên

                    $assignments = array_slice($tag_ids, 0, rand(0,8)); // cắt mảng
                    foreach($assignments as $tag_id){
                        DB::table('hobby_tag')
                            ->insert([
                                'hobby_id' => $hobby->id,
                                'tag_id' => $tag_id,
                                'created_at' => Now(), // nếu dùng DB Facade thì phải cập nhật timestamp manual
                                'updated_at' => Now()
                            ]);
                    }

                })
                ;
            });

    }
}
