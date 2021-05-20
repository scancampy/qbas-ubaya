package com.ubaya.qbas

import android.content.Context
import android.graphics.drawable.Drawable
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.RecyclerView
import kotlinx.android.synthetic.main.layout_item_report.view.*

class ReportAdapter(val absenceList:ArrayList<Absence>, val activity: AppCompatActivity):RecyclerView.Adapter<ReportAdapter.ReportViewHolder>() {
    class ReportViewHolder(v: View):RecyclerView.ViewHolder(v)

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ReportViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        var v = inflater.inflate(R.layout.layout_item_report, parent, false)
        return ReportAdapter.ReportViewHolder(v)
    }

    override fun onBindViewHolder(holder: ReportViewHolder, position: Int) {
        holder.itemView.txtCourseName.text = absenceList[position].course_name + " (KP: " + absenceList[position].course_kp + ")"
        holder.itemView.txtSchedule.text = absenceList[position].schedule_start_date
        absenceList[position]
        Log.d("schedulecek",absenceList[position].is_absence.toString() )
        if(absenceList[position].absence_date == "null") {
            holder.itemView.txtAbsence.text = "N/A"
            val d = holder.itemView.context.getDrawable(R.drawable.roundedgray)
            holder.itemView.txtAbsence.background = d
            holder.itemView.btnInfo.visibility = View.GONE
        } else if(absenceList[position].is_absence) {
            holder.itemView.txtAbsence.text = "Attend"
            val d = holder.itemView.context.getDrawable(R.drawable.roundedgreen)
            holder.itemView.txtAbsence.background = d
        } else if(!absenceList[position].is_absence) {
            holder.itemView.txtAbsence.text = "Not Attend"
            val d = holder.itemView.context.getDrawable(R.drawable.roundedred)
            holder.itemView.txtAbsence.background = d
            holder.itemView.btnInfo.visibility = View.GONE
        }

        holder.itemView.btnInfo.setOnClickListener {
            Log.d("cekriil", absenceList[position].toString())
            val d:CourseFeedbackDialogFragment = CourseFeedbackDialogFragment.newInstance(absenceList[position].course_name, absenceList[position].schedule_start_date,absenceList[position].topics, absenceList[position].id, absenceList[position].waktu_riil, absenceList[position].topik_riil, absenceList[position].akses_materi)

            d.show(activity.supportFragmentManager,"tes")
        }

    }

    override fun getItemCount(): Int {
        return absenceList.size
    }
}