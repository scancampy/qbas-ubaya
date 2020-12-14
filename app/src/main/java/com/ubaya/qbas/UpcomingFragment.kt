package com.ubaya.qbas

import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import com.android.volley.Request
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.google.android.material.snackbar.Snackbar
import kotlinx.android.synthetic.main.activity_main.*
import org.json.JSONObject

// TODO: Rename parameter arguments, choose names that match
// the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
private const val ARG_PARAM1 = "param1"
private const val ARG_PARAM2 = "param2"

/**
 * A simple [Fragment] subclass.
 * Use the [UpcomingFragment.newInstance] factory method to
 * create an instance of this fragment.
 */
class UpcomingFragment : Fragment() {
    // TODO: Rename and change types of parameters
    private var param1: String? = null
    private var param2: String? = null

    var v:View ?= null

    fun volleyGetServerDate() {
        var queue = Volley.newRequestQueue(activity)
        var url = Setting.baseUrl + "api/getserverdate"
        var sr = StringRequest(
            Request.Method.POST, url,
            Response.Listener<String> {
                var obj = JSONObject(it)
                var txtServerDate = v?.findViewById<TextView>(R.id.txtServerDate)
                txtServerDate?.text = obj.getString("serverdate")
            },
            Response.ErrorListener {
                Log.d("serverdateerror ", it.toString())
            })
        queue.add(sr)
    }

    fun volleyGetStudent() {
        var queue = Volley.newRequestQueue(activity)
        var url = Setting.baseUrl + "api/getstudent"
        var sr = object: StringRequest(
            Method.POST, url,
            Response.Listener<String> {
                Log.d("getstudent ", it)
                var obj = JSONObject(it)
                if(obj.getString("result") == "true") {
                    var data = obj.getJSONObject("data")
                    var fullname = data.getString("full_name")
                    var txtWelcome = v?.findViewById<TextView>(R.id.txtWelcome)
                    txtWelcome!!.text = "Welcome, ${fullname.toLowerCase().capitalize()}    "
                }
            },
            Response.ErrorListener {
                Log.d("getstudenterror ", it.toString())
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

    fun volleyGetCurrentClass() {
        var queue = Volley.newRequestQueue(activity)
        var url = Setting.baseUrl + "api/getcurrentclass"
        var sr = object: StringRequest(
            Method.POST, url,
            Response.Listener<String> {
                Log.d("getclass ", it)
                var obj = JSONObject(it)
                if (obj.getString("result") == "true") {
                    var arr = obj.getJSONArray("data")
                    var course_name = arr.getJSONObject(0).getString("course_name")
                    var course_id = arr.getJSONObject(0).getString("course_id")
                    var kp = arr.getJSONObject(0).getString("kp")
                    var start = arr.getJSONObject(0).getString("start_date")
                    var txtCourseName = v!!.findViewById<TextView>(R.id.txtCourseName)
                    txtCourseName.text = course_name

                    var txtCourseID = v!!.findViewById<TextView>(R.id.txtCourseID)
                    txtCourseID.text = "$course_id\nKP $kp"

                    var txtTime = v!!.findViewById<TextView>(R.id.txtCourseTime)
                    txtTime.text = start

                    v!!.findViewById<TextView>(R.id.txtNoClass).visibility = View.GONE
                    v!!.findViewById<TextView>(R.id.txtInstruction).text = "Request QR code from QBAS web, and then use app scan QR to record your attendances"
                }
            },
            Response.ErrorListener {
                Log.d("getclasserror ", it.toString())
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

    override fun onResume() {
        super.onResume()
        volleyGetServerDate()
        volleyGetStudent()
        volleyGetCurrentClass()
    }

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
        v = inflater.inflate(R.layout.fragment_upcoming, container, false)
        return v
    }

    companion object {
        /**
         * Use this factory method to create a new instance of
         * this fragment using the provided parameters.
         *
         * @param param1 Parameter 1.
         * @param param2 Parameter 2.
         * @return A new instance of fragment UpcomingFragment.
         */
        // TODO: Rename and change types and number of parameters
        @JvmStatic
        fun newInstance(param1: String, param2: String) =
            UpcomingFragment().apply {
                arguments = Bundle().apply {
                    putString(ARG_PARAM1, param1)
                    putString(ARG_PARAM2, param2)
                }
            }
    }
}