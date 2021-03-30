package com.ubaya.qbas

import android.content.Context
import android.content.DialogInterface
import android.graphics.Color
import android.graphics.drawable.ColorDrawable
import android.os.Bundle
import android.os.CountDownTimer
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.view.Window
import androidx.fragment.app.DialogFragment
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import kotlinx.android.synthetic.main.fragment_class_code_dialog.*
import org.json.JSONObject

class ClassCodeDialogFragment : DialogFragment() {
    private var nextCode:String = ""
    private var cttimer:CountDownTimer ?= null

    fun volleyGetAuthCode() {
        var queue = Volley.newRequestQueue(activity)
        var url = Setting.baseUrl + "api/requestauthcode"
        var sr = object: StringRequest(
            Method.POST, url,
            Response.Listener<String> {
                Log.d("getstudent ", it)
                var obj = JSONObject(it)
                if (obj.getString("result") == "true") {
                    var codes = obj.getString("code")
                    nextCode = codes
                }
            },
            Response.ErrorListener {
                Log.d("getstudent ", it.toString())
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

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        var v =  inflater.inflate(R.layout.fragment_class_code_dialog, container)
        dialog?.requestWindowFeature(Window.FEATURE_NO_TITLE)
        dialog?.getWindow()?.setBackgroundDrawable(ColorDrawable(Color.TRANSPARENT))
        val window: Window = dialog?.window!!
        window.setLayout(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.MATCH_PARENT)
        setStyle(DialogFragment.STYLE_NO_FRAME, android.R.style.Theme)
        dialog?.setCancelable(false)
        dialog?.setCanceledOnTouchOutside(false)
        return v
    }

    override fun onDismiss(dialog: DialogInterface) {
        super.onDismiss(dialog)
        //call parent to update its content
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        //txtClassCode.text = codes
        volleyGetAuthCode()
        cttimer = object : CountDownTimer(3000, 1000) {
            override fun onTick(millisUntilFinished: Long) {
                txtClassCode.text = nextCode
            }
            override fun onFinish() {
                volleyGetAuthCode()
                start()
            }
        }.start()

        btnDismiss.setOnClickListener {
            cttimer?.cancel()
            this.dismiss()
        }
    }


    companion object {
        var codes: String? = null

        fun newInstance(): ClassCodeDialogFragment {
            val fragment = ClassCodeDialogFragment()
            return fragment
        }
    }
}