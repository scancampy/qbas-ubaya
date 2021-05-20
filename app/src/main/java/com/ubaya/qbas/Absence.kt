package com.ubaya.qbas

data class Absence(var id:Int,
                   var course_open_id:Int,
                   var schedule_id:Int,
                   var absence_date:String,
                   var is_absence:Boolean,
                   var course_name:String,
                   var course_kp:String,
                   var schedule_start_date:String,
                   var topics:String,
                   var waktu_riil:String,
                   var topik_riil:String,
                   var akses_materi:String) {
}