package com.ubaya.qbas

import android.Manifest
import android.content.Intent
import android.content.pm.PackageManager
import android.os.Build
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.Toast
import com.google.zxing.Result
import kotlinx.android.synthetic.main.activity_q_r.*
import me.dm7.barcodescanner.zxing.ZXingScannerView

class QRActivity : AppCompatActivity(),ZXingScannerView.ResultHandler, View.OnClickListener {
    private lateinit var mScannerView: ZXingScannerView
    private var isCaptured = false

    companion object {
        var QRRESULT = "qrresult"
    }
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_q_r)
        initScannerView()
    }

    private fun initScannerView() {
        mScannerView = ZXingScannerView(this)
        mScannerView.setAutoFocus(true)
        mScannerView.setResultHandler(this)
        rootQR.addView(mScannerView)
    }

    override fun onResume() {
        doRequestPermission()
        mScannerView.startCamera()
        super.onResume()
    }


    private fun doRequestPermission() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            if (checkSelfPermission(Manifest.permission.CAMERA) != PackageManager.PERMISSION_GRANTED) {
                requestPermissions(arrayOf(Manifest.permission.CAMERA), 100)
            }
        }
    }

    override fun onRequestPermissionsResult(requestCode: Int, permissions: Array<out String>, grantResults: IntArray) {
        when (requestCode) {
            100 -> {
                initScannerView()
            }
            else -> {
                /* nothing to do in here */
            }
        }
    }

    override fun onPause() {
        //mScannerView.stopCamera()
        super.onPause()
    }

    override fun handleResult(p0: Result?) {
        Toast.makeText(this, "" + p0?.text.toString(), Toast.LENGTH_SHORT).show()
        //Log.d("QR result ", p0?.text.toString())
        var intent = Intent(this, DashboardActivity::class.java)
        intent.putExtra(QRRESULT, p0?.text.toString())
        startActivity(intent)
        this.finish()
    }

    override fun onBackPressed() {
        //super.onBackPressed()
        var intent = Intent(this, DashboardActivity::class.java)
        startActivity(intent)
        this.finish()
    }

    override fun onClick(p0: View?) {
    }

}