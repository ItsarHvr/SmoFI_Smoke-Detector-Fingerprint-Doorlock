# 🔐 SmoFi – Smart Door Lock & Smoke Detector System

**SmoFi** is a mini IoT project that integrates a smart door lock system and a smoke detection system, supported by a web dashboard built with Laravel. This system is designed to enhance the safety and security of a smart classroom by providing remote control, log access, and smoke detection alerts.

---

## 🚀 Key Features

* 🔥 **Automatic Smoke Detection**
  The sensor detects the presence of smoke and sends logs to the server.

* 🔐 **Smart Lock Control via Web**
  Admins can remotely unlock the door through the web dashboard.

* 📊 **Log Monitoring**
  The history of door activity and smoke levels is recorded and displayed on the website.

* 👤 **Admin Access Management**
  Only users with admin roles can unlock the door.

---

## 🛠️ Technologies Used

| Component     | Technology                                   |
| ------------- | -------------------------------------------- |
| Backend       | Laravel (PHP)                                |
| Frontend      | Blade Template + Bootstrap                   |
| Database      | MySQL                                        |
| IoT Device    | ESP32, ESP8266, MQ-2, FPM10A, Solenoid Lock  |
| Communication | MQTT                                         |

---

## 🔌 IoT Device Setup (Block Diagram)

![block_diagram](https://raw.githubusercontent.com/ItsarHvr/SmoFI_Smoke-Detector-Fingerprint-Doorlock/main/471b01cef42ce5f67f2caa885f0cf8c0e4ab55bf/web_view/block_diagram.png)

---

📸 Website Screenshots

1. 📝 Register Page
   ![register\_page](https://github.com/user-attachments/assets/37318707-661d-4019-85ca-d5d7c2fd6313)

2. 🔐 Login Page
   ![login\_page](https://github.com/user-attachments/assets/8f1ce761-c42c-4706-9f85-553ab0e247fb)

3. 🚪 Door Lock / Unlock Control
   ![door\_lock\_unlock\_page](https://github.com/user-attachments/assets/9f05beb0-6f3a-4cfd-8497-9805854ed59f)

4. ✋ Enroll Fingerprint Page
   ![enroll\_fingerprint\_page](https://github.com/user-attachments/assets/4c501d74-9dc5-4bff-93fb-2c6153f799c5)

5. 📑 Door Access Logs
   ![log\_access\_page](https://github.com/user-attachments/assets/4decfef1-8bd5-4fb6-825f-462cca110433)

6. 🔥 Smoke Monitoring Page
   ![smoke\_monitoring\_page](https://github.com/user-attachments/assets/feb39e3f-a5d1-4244-acd4-ef781d9baa86)

7. 👤 User List Page
   ![user\_list\_page](https://github.com/user-attachments/assets/da83876c-03f1-4fa4-89c5-b80034f8db1c)

---

## 👥 Contributors

| Name                          | Student ID | Role & Contribution                                                       |
| ----------------------------- | ---------- | ------------------------------------------------------------------------- |
| **Itsar Hevara**              | 2207421046 | System design and full module integration                                 |
| **Devina Anggraini**          | 2207421033 | Frontend UI development (dashboard & user pages)                          |
| **Alfarizki Nurachman**       | 2207421041 | Developed fingerprint log frontend and backend integration with WebSocket |
| **Abdurrahman Ammar Ihsan**   | 2207421047 | Implemented IoT Smart Door Lock (ESP32 & Solenoid Lock)                   |
| **Izzaturrachmi**             | 2207421050 | System security (admin access, validation, and authorization)             |
| **Jonathan Victorian Wijaya** | 2207421051 | Implemented IoT Smoke Detector (MQ-2 sensor)                              |

---
