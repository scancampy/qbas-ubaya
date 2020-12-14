package com.ubaya.qbas

import android.content.Context
import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.google.android.material.snackbar.Snackbar
import kotlinx.android.synthetic.main.activity_dashboard.*
import kotlinx.android.synthetic.main.activity_main.*
import org.json.JSONObject
import java.net.URL

class MainActivity : AppCompatActivity() {
    override fun onResume() {
        super.onResume()
        val sharedPref = getSharedPreferences("NRP", Context.MODE_PRIVATE)
        val ceknrp = sharedPref.getString("nrp","")
        if(ceknrp != "") {
            var intent = Intent(this, DashboardActivity::class.java)
            startActivity(intent)
            this.finish()
        }
    }
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)


        btnLogin.setOnClickListener {
            var ad = AlertDialog.Builder(this)
            ad.setMessage("Please wait...").setCancelable(false)
            var dialog = ad.create()
            dialog.show()

            var queue = Volley.newRequestQueue(this)
            var url = Setting.baseUrl + "api/signin"
            var sr = object: StringRequest(Method.POST, url,
                Response.Listener<String> {
                    var obj = JSONObject(it)
                    if (obj.getString("result") == "true") {
                        Log.d("signinsuccess ", it)

                        //Toast.makeText(this, " " + obj.getString("nrp"), Toast.LENGTH_SHORT).show()
                        val sharedPref = getSharedPreferences("NRP", Context.MODE_PRIVATE)
                        val ceknrp = sharedPref.getString("nrp", "")
                        if (ceknrp == "") {
                            sharedPref.edit().putString("nrp",  obj.getString("nrp")).apply()
                        }

                        var intent = Intent(this, DashboardActivity::class.java)
                        startActivity(intent)
                        this.finish()
                    } else {
                        Log.d("signinfailed", "failed")
                        Snackbar.make(rootMain, "Sign-in Failed", Snackbar.LENGTH_SHORT).show()
                    }

                    dialog.dismiss()
                },
                Response.ErrorListener {
                    Log.d("signinerror ", it.toString())
                    Snackbar.make(rootMain, "Sign-in Failed", Snackbar.LENGTH_SHORT).show()
                    dialog.dismiss()
                }) {
                override fun getParams(): MutableMap<String, String> {
                    var params = HashMap<String, String>()
                    params["snrp"] = txtSnrp.text.toString()
                    params["pin"] = txtPin.text.toString()
                    return params
                }
            }

            queue.add(sr)

        }
    }
}