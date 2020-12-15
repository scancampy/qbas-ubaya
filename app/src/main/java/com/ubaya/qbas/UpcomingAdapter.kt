package com.ubaya.qbas

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.recyclerview.widget.RecyclerView
import kotlinx.android.synthetic.main.upcoming_recycler_layout.view.*

class UpcomingAdapter(val schedule: ArrayList<Schedule>, val ctx: Context): RecyclerView.Adapter<UpcomingAdapter.RecycleUpcomingViewHolder>() {
    class RecycleUpcomingViewHolder(val v: View) : RecyclerView.ViewHolder(v)

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): RecycleUpcomingViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        var v = inflater.inflate(R.layout.upcoming_recycler_layout, parent, false)
        return UpcomingAdapter.RecycleUpcomingViewHolder(v)
    }

    override fun onBindViewHolder(holder: RecycleUpcomingViewHolder, position: Int) {
        holder.v.txtCourseName2.text = schedule[position].course_name
        holder.v.txtCourseId.text = schedule[position].course_id
        holder.v.txtKP.text = " (" + schedule[position].kp + ")"
        holder.v.txtDate.text = schedule[position].start_date_format
    }

    override fun getItemCount(): Int {
        return schedule.size
    }
}