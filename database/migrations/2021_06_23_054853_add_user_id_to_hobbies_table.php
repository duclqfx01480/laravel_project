<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToHobbiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hobbies', function (Blueprint $table) {
            // Định nghĩa cột cần thêm
            $table->unsignedBigInteger('user_id')
                ->after('id')
                ->nullable();

            // Sau đó thêm FK để kết nối bảng user và hobbies, thông qua FK hobbies(user_id)->users(id)
            // user_id [của bảng hobbies] reference đến id của bảng users, nếu có delete thì cascade
            // cascade: Nếu user bị xóa thì hobbies của user đó cũng bị xóa luôn
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hobbies', function (Blueprint $table) {
            // Làm ngược lại những gì đã làm ở phương thức up
            // Xóa FK - nhớ phải dùng mảng []
            $table->dropForeign(['user_id']);
            // Sau đó xóa cột đã thêm  (user_id)
            $table->dropColumn('user_id');
        });
    }
}
