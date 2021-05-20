package com.ubaya.qbas

import android.content.Context
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import kotlinx.android.synthetic.main.fragment_report.view.*
import org.json.JSONObject

// TODO: Rename parameter arguments, choose names that match
// the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
private const val ARG_PARAM1 = "param1"
private const val ARG_PARAM2 = "param2"

/**
 * A simple [Fragment] subclass.
 * Use the [ReportFragment.newInstance] factory method to
 * create an instance of this fragment.
 */
class ReportFragment : Fragment() {
    // TODO: Rename and change types of parameters
    private var param1: String? = null
    private var param2: String? = null

    var absenceList:ArrayList<Absence> = ArrayList()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        arguments?.let {
            param1 = it.getString(ARG_PARAM1)
            param2 = it.getString(ARG_PARAM2)
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_report, container, false)
    }

    fun volleyGetStudentReport(v:View) {
        var queue = Volley.newRequestQueue(activity)
        var url = Setting.baseUrl + "api/getstudentreport"
        var sr = object: StringRequest(
            Method.POST, url,
            Response.Listener<String> {
               // Log.d("getstudentreport ", it)
                var obj = JSONObject(it)
                if (obj.getString("result") == "true") {
                    Log.d("getstudentreport", obj.getString("myatt"))
                    var data = obj.getJSONArray("myatt")
                    absenceList = ArrayList()

                    for(i in 0 until data.length()) {
                        //Log.d("getstudentreport", data.getString(i))
                        var id = data.getJSONObject(i).getInt("id")
                        var course_open_id = data.getJSONObject(i).getInt("course_open_id")
                        var schedule_id = data.getJSONObject(i).getInt("schedule_id")
                        var absence_date = ""
                        if(!data.getJSONObject(i).getString("absence_date").isNullOrBlank()) {
                            absence_date = data.getJSONObject(i).getString("absence_date")
                        }
                        var is_absence = false
                        if(data.getJSONObject(i).getInt("is_absence") == 1) {
                            is_absence = true
                        } else {
                            is_absence = false
                        }
                        var course_name = data.getJSONObject(i).getString("course_short_name")
                        var course_kp = data.getJSONObject(i).getString("KP")
                        var schedule_start_date  = data.getJSONObject(i).getString("start_date_formatted")
                        var topics = data.getJSONObject(i).getString("topics")
                        var waktu_riil = data.getJSONObject(i).getString("waktu_riil")
                        var topik_riil = data.getJSONObject(i).getString("topik_riil")
                        var akses_materi = data.getJSONObject(i).getString("akses_materi")
                        absenceList.add(Absence(id,course_open_id, schedule_id, absence_date, is_absence,course_name, course_kp, schedule_start_date, topics, waktu_riil, topik_riil, akses_materi))
                    }

                    Log.d("getstudentreport", absenceList.toString())

                    var rv = v!!.findViewById<RecyclerView>(R.id.recyclerView)
                    val lm: LinearLayoutManager = LinearLayoutManager(activity)
                    rv?.layoutManager = lm
                    rv?.setHasFixedSize(true)
                rv.adapter = ReportAdapter(absenceList, activity as AppCompatActivity)
                   // Log.d("getupcoming ", schedule.toString())
                }

                v.swiperefresh.isRefreshing = false
            },
            Response.ErrorListener {
                Log.d("getstudentreport ", it.toString())
            }){
            override fun getParams(): MutableMap<String, String> {
                var params = HashMap<String, String>()
                val sharedPref = activity?.getSharedPreferences("NRP", Context.MODE_PRIVATE)
                val ceknrp = sharedPref?.getString("nrp","")

                params["nrp"] = ceknrp.toString()
                return params
            }
        }
        queue.add(sr)
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        volleyGetStudentReport(view)
        view.swiperefresh.setOnRefreshListener {
            volleyGetStudentReport(view)
        }
    }

    companion object {
        /**
         * Use this factory method to create a new instance of
         * this fragment using the provided parameters.
         *
         * @param param1 Parameter 1.
         * @param param2 Parameter 2.
         * @return A new instance of fragment ReportFragment.
         */
        // TODO: Rename and change types and number of parameters
        @JvmStatic
        fun newInstance(param1: String, param2: String) =
            ReportFragment().apply {
                arguments = Bundle().apply {
                    putString(ARG_PARAM1, param1)
                    putString(ARG_PARAM2, param2)
                }
            }
    }
}