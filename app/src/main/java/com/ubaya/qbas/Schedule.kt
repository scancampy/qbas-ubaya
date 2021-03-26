package com.ubaya.qbas

data class Schedule(var course_open_id:Int,
                    var course_id:String,
                    var course_name:String,
                    var kp:String, var id:Int,
                    var start_date:String,
                    var start_date_format: String,
                    var end_date:String,
                    var method:String) {
}