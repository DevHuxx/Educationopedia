/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState, useRef, useEffect, useCallback } from "react";
import { Link, useNavigate } from "react-router-dom";
import { motion, AnimatePresence } from "framer-motion";
import { BookOpen, CheckCircle, Camera, User, FileText, ChevronRight, ChevronLeft, Loader2, AlertTriangle, Smile } from "lucide-react";
import { Button } from "@/components/ui/button";

type Step = "basic" | "details" | "photo" | "success";

interface FormData {
  
  name: string;
  email: string;
  phone: string;
  
  father_name: string;
  father_phone: string;
  dob: string;
  city: string;
  state: string;
  class_completed: string;
  neet_status: string;
  neet_score: string;
  target_country: string;
  target_course: string;
  
  photo_base64: string;
}

const STEPS: Step[] = ["basic", "details", "photo", "success"];

const STEP_LABELS = [
  { label: "Basic Info", icon: User },
  { label: "Details", icon: FileText },
  { label: "Photo", icon: Camera },
];

const ScholarshipExam = () => {
  const navigate = useNavigate();
  const [currentStep, setCurrentStep] = useState<Step>("basic");
  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState("");

  const [form, setForm] = useState<FormData>({
    name: "", email: "", phone: "",
    father_name: "", father_phone: "", dob: "", city: "", state: "",
    class_completed: "", neet_status: "", neet_score: "", target_country: "", target_course: "",
    photo_base64: "",
  });

  
  const videoRef = useRef<HTMLVideoElement>(null);
  const canvasRef = useRef<HTMLCanvasElement>(null);
  const streamRef = useRef<MediaStream | null>(null);
  const intervalRef = useRef<any>(null);
  const faceFrameCount = useRef(0); 
  const [cameraOn, setCameraOn] = useState(false);
  const [faceDetected, setFaceDetected] = useState(false);
  const [faceHoldProgress, setFaceHoldProgress] = useState(0); 
  const [photoTaken, setPhotoTaken] = useState(false);
  const FACE_HOLD_FRAMES = 7; 

  const update = (field: keyof FormData, value: string) => {
    setForm(prev => ({ ...prev, [field]: value }));
    setErrorMsg("");
  };

  const stepIndex = STEPS.indexOf(currentStep);

  const goNext = () => setCurrentStep(STEPS[stepIndex + 1] as Step);
  const goBack = () => setCurrentStep(STEPS[stepIndex - 1] as Step);

  
  const validateBasic = () => {
    if (!form.name.trim()) return "Please enter your full name.";
    if (!form.email.trim() || !form.email.includes("@")) return "Please enter a valid email.";
    if (!form.phone.trim() || form.phone.length < 10) return "Please enter a valid phone number.";
    return null;
  };

  
  const validateDetails = () => {
    if (!form.father_name.trim()) return "Please enter your father's name.";
    if (!form.father_phone.trim() || form.father_phone.length < 10) return "Please enter your father's phone.";
    if (!form.dob) return "Please select your date of birth.";
    if (!form.city.trim()) return "Please enter your city.";
    if (!form.state.trim()) return "Please enter your state.";
    if (!form.class_completed) return "Please select your highest class completed.";
    if (!form.neet_status) return "Please select your NEET status.";
    if (!form.target_country) return "Please select your target country.";
    if (!form.target_course) return "Please select your target course.";
    return null;
  };

  
  const startCamera = async () => {
    try {
      
      const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
      streamRef.current = stream;
      if (videoRef.current) {
        const video = videoRef.current;
        video.srcObject = stream;
        video.setAttribute('playsinline', 'true');
        video.setAttribute('muted', 'true');
        
        try { await video.play(); } catch (_) {}
      }
      setCameraOn(true);
      
      setTimeout(() => startFaceDetection(), 800);
    } catch {
      setErrorMsg("Camera access denied. Please allow camera permission and try again.");
    }
  };

  const stopCamera = () => {
    if (streamRef.current) {
      streamRef.current.getTracks().forEach(t => t.stop());
      streamRef.current = null;
    }
    if (intervalRef.current) clearInterval(intervalRef.current);
    faceFrameCount.current = 0;
    setCameraOn(false);
    setFaceDetected(false);
    setFaceHoldProgress(0);
  };

  
  const getCenterVariance = () => {
    if (!videoRef.current || !canvasRef.current) return 0;
    const video = videoRef.current;
    const canvas = canvasRef.current;
    const ctx = canvas.getContext("2d");
    if (!ctx || video.videoWidth === 0 || video.readyState < 2) return 0;
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    const cx = Math.floor(canvas.width / 2);
    const cy = Math.floor(canvas.height / 2);
    const size = Math.floor(Math.min(canvas.width, canvas.height) * 0.25);
    const imgData = ctx.getImageData(cx - size, cy - size, size * 2, size * 2);
    let sum = 0, sq = 0;
    const len = imgData.data.length / 4;
    for (let i = 0; i < imgData.data.length; i += 4) {
      const luma = 0.299 * imgData.data[i] + 0.587 * imgData.data[i + 1] + 0.114 * imgData.data[i + 2];
      sum += luma; sq += luma * luma;
    }
    const mean = sum / len;
    return (sq / len) - (mean * mean);
  };

  
  const startFaceDetection = () => {
    faceFrameCount.current = 0;
    const interval = setInterval(() => {
      const variance = getCenterVariance();
      const facePresentNow = variance > 600;
      if (facePresentNow) {
        faceFrameCount.current = Math.min(faceFrameCount.current + 1, FACE_HOLD_FRAMES);
      } else {
        
        faceFrameCount.current = 0;
      }
      const progress = Math.round((faceFrameCount.current / FACE_HOLD_FRAMES) * 100);
      setFaceHoldProgress(progress);
      setFaceDetected(faceFrameCount.current >= FACE_HOLD_FRAMES);
    }, 300);
    intervalRef.current = interval;
  };

  const capturePhoto = () => {
    if (!videoRef.current || !canvasRef.current) return;
    
    const variance = getCenterVariance();
    if (variance < 600) {
      setErrorMsg("No face detected at capture time! Please keep your face in the frame.");
      faceFrameCount.current = 0;
      setFaceDetected(false);
      setFaceHoldProgress(0);
      return;
    }
    const video = videoRef.current;
    const canvas = canvasRef.current;
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext("2d");
    if (!ctx) return;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    const base64 = canvas.toDataURL("image/jpeg", 0.85);
    update("photo_base64", base64);
    setPhotoTaken(true);
    stopCamera();
  };

  const retakePhoto = () => {
    update("photo_base64", "");
    setPhotoTaken(false);
    faceFrameCount.current = 0;
    setFaceDetected(false);
    setFaceHoldProgress(0);
    startCamera();
  };

  useEffect(() => {
    if (currentStep === "photo") {
      startCamera();
    } else {
      stopCamera();
    }
    return () => stopCamera();
  }, [currentStep]);

  
  const handleSubmit = async () => {
    if (!form.photo_base64) {
      setErrorMsg("Please capture your photo first.");
      return;
    }
    setLoading(true);
    setErrorMsg("");
    try {
      const res = await fetch("/backend/exam_api.php?action=register", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(form),
      });
      const data = await res.json();
      if (data.success) {
        setCurrentStep("success");
      } else {
        setErrorMsg(data.error || "Registration failed.");
      }
    } catch {
      setErrorMsg("Network error. Please try again.");
    } finally {
      setLoading(false);
    }
  };

  const inputCls = "w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none bg-gray-50 focus:bg-white transition-all text-gray-800";
  const labelCls = "block text-sm font-semibold text-gray-700 mb-1";

  return (
    <div className="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50 py-10 px-4">
      <div className="max-w-2xl mx-auto">

        
        <div className="text-center mb-8">
          <div className="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
            <BookOpen className="w-8 h-8 text-white" />
          </div>
          <h1 className="text-3xl font-bold text-gray-900">Scholarship Exam Registration</h1>
          <p className="text-gray-500 mt-2">Complete all steps to receive your exam credentials</p>
        </div>

        
        {currentStep !== "success" && (
          <div className="flex items-center justify-center gap-2 mb-8">
            {STEP_LABELS.map((s, i) => {
              const Icon = s.icon;
              const isActive = i === stepIndex;
              const isDone = i < stepIndex;
              return (
                <div key={i} className="flex items-center gap-2">
                  <div className={`flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold transition-all ${
                    isActive ? "bg-indigo-600 text-white shadow-md shadow-indigo-200"
                    : isDone ? "bg-green-100 text-green-700"
                    : "bg-gray-100 text-gray-400"
                  }`}>
                    <Icon className="w-4 h-4" />
                    <span className="hidden sm:inline">{s.label}</span>
                    <span className="sm:hidden">{i + 1}</span>
                  </div>
                  {i < STEP_LABELS.length - 1 && (
                    <div className={`w-6 h-0.5 ${isDone ? "bg-green-400" : "bg-gray-200"}`} />
                  )}
                </div>
              );
            })}
          </div>
        )}

        <AnimatePresence mode="wait">
          <motion.div
            key={currentStep}
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            exit={{ opacity: 0, x: -20 }}
            transition={{ duration: 0.25 }}
            className="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
          >

            
            {currentStep === "basic" && (
              <div className="p-8">
                <h2 className="text-xl font-bold text-gray-800 mb-6">Personal Information</h2>
                {errorMsg && <div className="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">{errorMsg}</div>}
                <div className="space-y-5">
                  <div>
                    <label className={labelCls}>Full Name *</label>
                    <input type="text" className={inputCls} placeholder="e.g. Rahul Sharma" value={form.name} onChange={e => update("name", e.target.value)} />
                  </div>
                  <div>
                    <label className={labelCls}>Email Address *</label>
                    <input type="email" className={inputCls} placeholder="you@example.com" value={form.email} onChange={e => update("email", e.target.value)} />
                    <p className="text-xs text-gray-400 mt-1">Your exam credentials will be sent to this email.</p>
                  </div>
                  <div>
                    <label className={labelCls}>Phone Number *</label>
                    <input type="tel" className={inputCls} placeholder="+91 9876543210" value={form.phone} onChange={e => update("phone", e.target.value)} />
                  </div>
                </div>
                <div className="flex justify-end mt-8">
                  <Button onClick={() => { const e = validateBasic(); if (e) { setErrorMsg(e); return; } goNext(); }}
                    className="bg-indigo-600 hover:bg-indigo-700 text-white px-8 h-11">
                    Continue <ChevronRight className="ml-1 w-4 h-4" />
                  </Button>
                </div>
              </div>
            )}

            
            {currentStep === "details" && (
              <div className="p-8">
                <h2 className="text-xl font-bold text-gray-800 mb-6">Academic & Family Details</h2>
                {errorMsg && <div className="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">{errorMsg}</div>}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                  <div>
                    <label className={labelCls}>Father's Name *</label>
                    <input type="text" className={inputCls} placeholder="Father's full name" value={form.father_name} onChange={e => update("father_name", e.target.value)} />
                  </div>
                  <div>
                    <label className={labelCls}>Father's Phone *</label>
                    <input type="tel" className={inputCls} placeholder="+91 9876543210" value={form.father_phone} onChange={e => update("father_phone", e.target.value)} />
                  </div>
                  <div>
                    <label className={labelCls}>Date of Birth *</label>
                    <input type="date" className={inputCls} value={form.dob} onChange={e => update("dob", e.target.value)} />
                  </div>
                  <div>
                    <label className={labelCls}>Highest Class Completed *</label>
                    <select className={inputCls} value={form.class_completed} onChange={e => update("class_completed", e.target.value)}>
                      <option value="">Select...</option>
                      <option>10th (SSC)</option>
                      <option>11th</option>
                      <option>12th (HSC) - Appearing</option>
                      <option>12th (HSC) - Passed</option>
                      <option>Graduate</option>
                    </select>
                  </div>
                  <div>
                    <label className={labelCls}>City *</label>
                    <input type="text" className={inputCls} placeholder="Your city" value={form.city} onChange={e => update("city", e.target.value)} />
                  </div>
                  <div>
                    <label className={labelCls}>State *</label>
                    <input type="text" className={inputCls} placeholder="Your state" value={form.state} onChange={e => update("state", e.target.value)} />
                  </div>
                  <div className="sm:col-span-2">
                    <label className={labelCls}>NEET Status *</label>
                    <select className={inputCls} value={form.neet_status} onChange={e => update("neet_status", e.target.value)}>
                      <option value="">Select your NEET status...</option>
                      <option>Going to attempt NEET (First Timer)</option>
                      <option>Appearing in NEET 2025</option>
                      <option>Appeared in NEET 2024</option>
                      <option>Appeared in NEET 2023</option>
                      <option>NEET Qualified - Have Score</option>
                      <option>Not appearing for NEET</option>
                    </select>
                  </div>
                  {(form.neet_status === "NEET Qualified - Have Score" || form.neet_status.startsWith("Appeared")) && (
                    <div className="sm:col-span-2">
                      <label className={labelCls}>NEET Score</label>
                      <input type="number" className={inputCls} placeholder="e.g. 450" value={form.neet_score} onChange={e => update("neet_score", e.target.value)} />
                    </div>
                  )}
                  <div>
                    <label className={labelCls}>Target Country *</label>
                    <select className={inputCls} value={form.target_country} onChange={e => update("target_country", e.target.value)}>
                      <option value="">Select country...</option>
                      {["Russia","Georgia","Uzbekistan","Kazakhstan","Kyrgyzstan","China","Nepal","Iran","Bangladesh"].map(c => (
                        <option key={c}>{c}</option>
                      ))}
                      <option>Not Decided Yet</option>
                    </select>
                  </div>
                  <div>
                    <label className={labelCls}>Target Course *</label>
                    <select className={inputCls} value={form.target_course} onChange={e => update("target_course", e.target.value)}>
                      <option value="">Select course...</option>
                      <option>MBBS</option>
                      <option>BDS (Dentistry)</option>
                      <option>Nursing</option>
                      <option>Pharmacy</option>
                      <option>Engineering</option>
                      <option>Not Decided Yet</option>
                    </select>
                  </div>
                </div>
                <div className="flex justify-between mt-8">
                  <Button variant="outline" onClick={goBack} className="px-6 h-11">
                    <ChevronLeft className="mr-1 w-4 h-4" /> Back
                  </Button>
                  <Button onClick={() => { const e = validateDetails(); if (e) { setErrorMsg(e); return; } goNext(); }}
                    className="bg-indigo-600 hover:bg-indigo-700 text-white px-8 h-11">
                    Continue <ChevronRight className="ml-1 w-4 h-4" />
                  </Button>
                </div>
              </div>
            )}

            
            {currentStep === "photo" && (
              <div className="p-8">
                <h2 className="text-xl font-bold text-gray-800 mb-2">Live Photo Capture</h2>
                <p className="text-gray-500 text-sm mb-6">Position your face in the center of the frame. We will auto-detect your face.</p>
                {errorMsg && <div className="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">{errorMsg}</div>}

                {!photoTaken ? (
                  <div className="flex flex-col items-center gap-4">
                    <div className="relative w-full max-w-sm rounded-2xl overflow-hidden bg-gray-900 shadow-xl border-4 border-dashed border-gray-300">
                      <video ref={videoRef} autoPlay playsInline muted className="w-full object-cover" style={{ height: "300px" }} />
                      <canvas ref={canvasRef} className="hidden" />

                      
                      <div className={`absolute inset-0 flex items-center justify-center pointer-events-none`}>
                        <div className={`w-40 h-48 rounded-full border-4 transition-all duration-300 ${faceDetected ? "border-green-400 shadow-[0_0_20px_rgba(74,222,128,0.5)]" : "border-white/40"}`} />
                      </div>

                      
                      <div className={`absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold ${faceDetected ? "bg-green-500 text-white" : "bg-black/60 text-white"}`}>
                        {faceDetected ? (
                          <><Smile className="w-4 h-4" /> Face Detected!</>
                        ) : (
                          <><Camera className="w-4 h-4" /> Searching for face...</>
                        )}
                      </div>
                    </div>

                      
                      {cameraOn && !photoTaken && (
                        <div className="w-full max-w-sm">
                          <div className="flex justify-between text-xs text-gray-500 mb-1">
                            <span>{faceDetected ? "✅ Hold still to capture!" : "👤 Position your face in the frame"}</span>
                            <span>{faceHoldProgress}%</span>
                          </div>
                          <div className="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div
                              className={`h-full rounded-full transition-all duration-300 ${faceDetected ? "bg-green-500" : faceHoldProgress > 0 ? "bg-yellow-400" : "bg-gray-300"}`}
                              style={{ width: `${faceHoldProgress}%` }}
                            />
                          </div>
                        </div>
                      )}

                    {!cameraOn ? (
                      <Button onClick={startCamera} className="bg-indigo-600 hover:bg-indigo-700 text-white px-8 h-11">
                        <Camera className="mr-2 w-4 h-4" /> Open Camera
                      </Button>
                    ) : (
                      <Button
                        onClick={capturePhoto}
                        disabled={!faceDetected}
                        className={`px-8 h-12 text-white font-semibold transition-all ${faceDetected ? "bg-green-600 hover:bg-green-700 shadow-lg shadow-green-200 scale-105" : "bg-gray-400 cursor-not-allowed opacity-70"}`}
                      >
                        <Camera className="mr-2 w-5 h-5" />
                        {faceDetected ? "Capture Photo Now" : "Waiting for Face..."}
                      </Button>
                    )}
                  </div>
                ) : (
                  <div className="flex flex-col items-center gap-4">
                    <div className="relative">
                      <img src={form.photo_base64} className="w-48 h-56 object-cover rounded-2xl shadow-lg border-4 border-green-400" alt="Captured" />
                      <div className="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shadow">
                        <CheckCircle className="w-5 h-5 text-white" />
                      </div>
                    </div>
                    <p className="text-green-700 font-semibold">Photo captured successfully!</p>
                    <Button variant="outline" onClick={retakePhoto} className="text-sm h-9">
                      Retake Photo
                    </Button>
                  </div>
                )}

                <div className="flex justify-between mt-8">
                  <Button variant="outline" onClick={goBack} className="px-6 h-11">
                    <ChevronLeft className="mr-1 w-4 h-4" /> Back
                  </Button>
                  <Button
                    onClick={handleSubmit}
                    disabled={!form.photo_base64 || loading}
                    className="bg-indigo-600 hover:bg-indigo-700 text-white px-8 h-11 disabled:opacity-50"
                  >
                    {loading ? <><Loader2 className="mr-2 w-4 h-4 animate-spin" /> Submitting...</> : <>Submit & Get Credentials</>}
                  </Button>
                </div>
              </div>
            )}

            
            {currentStep === "success" && (
              <div className="p-10 text-center">
                <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                  <CheckCircle className="w-12 h-12 text-green-500" />
                </div>
                <h2 className="text-2xl font-bold text-gray-800 mb-2">Registration Complete!</h2>
                <p className="text-gray-500 mb-8">
                  Your exam login credentials have been sent to <strong>{form.email}</strong>.<br />
                  <span className="text-sm text-gray-400">Please check your inbox (and spam folder).</span>
                </p>
                <Link to="/exam/login">
                  <Button className="w-full h-12 bg-indigo-600 hover:bg-indigo-700 text-white text-lg">
                    Go to Exam Login →
                  </Button>
                </Link>
              </div>
            )}

          </motion.div>
        </AnimatePresence>
      </div>
    </div>
  );
};

export default ScholarshipExam;
