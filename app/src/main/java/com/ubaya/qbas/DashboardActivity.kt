package com.ubaya.qbas

import android.content.Context
import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.fragment.app.Fragment
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import kotlinx.android.synthetic.main.activity_dashboard.*
import org.json.JSONObject

class DashboardActivity : AppCompatActivity() {
    var fragments:ArrayList<Fragment> = ArrayList()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_dashboard)
        bottomNav.itemIconTintList = null
        fragments.add(UpcomingFragment())
        var adapter = PagerAdapter(this, fragments)
        viewPager.adapter = adapter

        if(intent.getStringExtra(QRActivity.QRRESULT) != null) {
            //Toast.makeText(this, "" + intent.getStringExtra(QRActivity.QRRESULT), Toast.LENGTH_SHORT).show()
            var qr = intent.getStringExtra(QRActivity.QRRESULT)
            var queue = Volley.newRequestQueue(this)
            var url = Setting.baseUrl + "api/checkqr"
            var sr = object: StringRequest(
                Method.POST, url,
                Response.Listener<String> {
                    Log.d("checkqr ", it)
                    var obj = JSONObject(it)
                    if(obj.getString("result") == "true") {
                        var ad = AlertDialog.Builder(this)
                        ad.setMessage("Your attendance have been recorded")
                        ad.setTitle("Success")
                        ad.setPositiveButton("Dismiss", null)
                        var dialog = ad.create()
                        dialog.show()
                    } else {
                        var ad = AlertDialog.Builder(this)
                        ad.setMessage("Invalid QR code")
                        ad.setTitle("Failed")
                        ad.setPositiveButton("Dismiss", null)
                        var dialog = ad.create()
                        dialog.show()
                    }
                },
                Response.ErrorListener {
                    Log.d("checkqr ", it.toString())
                    var ad = AlertDialog.Builder(this)
                    ad.setMessage("Invalid QR code")
                    ad.setTitle("Failed")
                    ad.setPositiveButton("Dismiss", null)
                    var dialog = ad.create()
                    dialog.show()
                }){
                override fun getParams(): MutableMap<String, String> {
                    var params = HashMap<String, String>()
                    val sharedPref = this@DashboardActivity?.getSharedPreferences("NRP", Context.MODE_PRIVATE)
                    val ceknrp = sharedPref?.getString("nrp","")

                    params["nrp"] = ceknrp.toString()
                    params["qr"] = qr.toString()
                    return params
                }
            }
            queue.add(sr)
        }

        bottomNav.setOnNavigationItemSelectedListener {
            if(it.itemId == R.id.itemScan) {
                var intent = Intent(this, QRActivity::class.java)
                startActivity(intent)
                this.finish()
            }
            true
        }
    }
}