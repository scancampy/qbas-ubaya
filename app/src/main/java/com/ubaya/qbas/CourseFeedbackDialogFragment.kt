package com.ubaya.qbas

import android.content.Context
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.RadioButton
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.DialogFragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import kotlinx.android.synthetic.main.fragment_course_feedback_dialog.*
import kotlinx.android.synthetic.main.fragment_report.view.*
import kotlinx.android.synthetic.main.layout_item_report.*
import kotlinx.android.synthetic.main.layout_item_report.txtCourseName
import org.json.JSONObject

// TODO: Rename parameter arguments, choose names that match
// the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
private const val ARG_PARAM1 = "course_name"
private const val ARG_PARAM2 = "schedule_start_date"
private const val ARG_PARAM3 = "topics"
private const val ARG_PARAM4 = "id"
private const val ARG_PARAM5 = "waktu_riil"
private const val ARG_PARAM6 = "topik_riil"
private const val ARG_PARAM7 = "akses_materi"

/**
 * A simple [Fragment] subclass.
 * Use the [CourseFeedbackDialogFragment.newInstance] factory method to
 * create an instance of this fragment.
 */
class CourseFeedbackDialogFragment : DialogFragment() {
    // TODO: Rename and change types of parameters
    private var course_name: String? = null
    private var schedule_start_date:String? = null
    private var topics:String? = null
    private var id:Int? = null
    private var waktu_riil:String? = null
    private var topik_riil:String? = null
    private var akses_materi:String? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        arguments?.let {
            course_name = it.getString(ARG_PARAM1)
            schedule_start_date = it.getString(ARG_PARAM2)
            topics = it.getString(ARG_PARAM3)
            waktu_riil = it.getString(ARG_PARAM5)
            topik_riil = it.getString(ARG_PARAM6)
            akses_materi = it.getString(ARG_PARAM7)
            id = it.getInt(ARG_PARAM4)
            Log.d("cekriil waktu", waktu_riil.toString())
            Log.d("cekriil topik", topik_riil.toString())
            Log.d("cekriil materi", akses_materi.toString())
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_course_feedback_dialog, container, false)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        txtCourseName.text = course_name
        txtScheduleStartDate.text = schedule_start_date
        txtTopics.text = topics

        if(waktu_riil == "Setara") radioSetara.isChecked =true
        if(waktu_riil == "Lebih Banyak") radioBanyak.isChecked =true
        if(waktu_riil == "Lebih Sedikit") radioSedikit.isChecked =true

        Log.d("cekriil topik radio", topik_riil.toString())
        if(topik_riil == "Ya") radioYa.isChecked =true
        if(topik_riil == "Tidak") radioTidak.isChecked =true

        if(akses_materi == "Lengkap") radioLengkap.isChecked =true
        if(akses_materi == "Belum Ada") radioBelum.isChecked =true
        if(akses_materi == "Ada, tidak lengkap") radioTidakLengkap.isChecked =true


        btnUpdate.setOnClickListener {
            var radioMateri = view.findViewById<RadioButton>(radioMateri.checkedRadioButtonId)
            var radioTopik = view.findViewById<RadioButton>(radioTopik.checkedRadioButtonId)
            var radioWaktu = view.findViewById<RadioButton>(radioWaktu.checkedRadioButtonId)

            volleyUpdateCourseReview(it, id!!,radioWaktu.tag.toString(), radioTopik.tag.toString(),radioMateri.tag.toString())
            Toast.makeText(it.context, "Thanks for the feedback", Toast.LENGTH_SHORT).show()
            this.dismiss()
        }
    }

    fun volleyUpdateCourseReview(v:View, id:Int, wakturiil:String, topikriil:String, aksesmateri:String) {
        var queue = Volley.newRequestQueue(activity)
        var url = Setting.baseUrl + "api/updatefeedback"
        var sr = object: StringRequest(
            Method.POST, url,
            Response.Listener<String> {
                Log.d("getstudentreport ", it)

            },
            Response.ErrorListener {
                Log.d("getstudentreport ", it.toString())
            }){
            override fun getParams(): MutableMap<String, String> {
                var params = HashMap<String, String>()
                val sharedPref = activity?.getSharedPreferences("NRP", Context.MODE_PRIVATE)
                val ceknrp = sharedPref?.getString("nrp","")

                params["id"] = id.toString()
                params["waktu_riil"] = wakturiil
                params["topik_riil"] = topikriil
                params["akses_materi"] = aksesmateri
                return params
            }
        }
        queue.add(sr)
    }

    companion object {
        /**
         * Use this factory method to create a new instance of
         * this fragment using the provided parameters.
         *
         * @param param1 Parameter 1.
         * @param param2 Parameter 2.
         * @return A new instance of fragment CourseFeedbackDialogFragment.
         */
        // TODO: Rename and change types and number of parameters
        @JvmStatic
        fun newInstance(course_name: String, schedule_start_date:String, topics:String, id:Int, waktu_riil:String, topik_riil:String, akses_materi:String) =
            CourseFeedbackDialogFragment().apply {
                arguments = Bundle().apply {
                    putString(ARG_PARAM1, course_name)
                    putString(ARG_PARAM2,schedule_start_date)
                    putString(ARG_PARAM3,topics)
                    putString(ARG_PARAM5,waktu_riil)
                    putString(ARG_PARAM6,topik_riil)
                    putString(ARG_PARAM7,akses_materi)
                    putInt(ARG_PARAM4,id)
                }
            }
    }
}