<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHobbyTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hobby_tag', function (Blueprint $table) {
            // Xóa cột id đi vì không cần cột này, chỉ cần hobby_id và tag_id
            //$table->id();
            $table->unsignedBigInteger('hobby_id')->nullable();
            $table->unsignedBigInteger('tag_id')->nullable();
            $table->timestamps();

            // Tạo PK
            // Chú ý đặt trong mảng []
            $table->primary(['hobby_id', 'tag_id']);

            // Thêm FK
            // hobby_id -> hobbies(id)
            // tag_id -> tags(id)
            $table->foreign('hobby_id')
                ->references('id')
                ->on('hobbies')
                ->onDelete('cascade');
            // Cascade vì muốn: nếu xóa hobby thì cũng xóa luôn kết nối giữa hobby đó và tag

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
            // Cascade vì muốn: nếu xóa tag thì cũng xóa luôn kết nối giữa tag đó và hobby
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hobby_tag');
    }
}
