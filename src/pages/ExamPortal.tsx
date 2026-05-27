/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState, useEffect, useRef } from "react";
import { useNavigate } from "react-router-dom";
import { motion } from "framer-motion";
import { Camera, Clock, AlertTriangle, CheckCircle } from "lucide-react";
import { Button } from "@/components/ui/button";

interface Question {
  id: number;
  question_text: string;
  opt_a: string;
  opt_b: string;
  opt_c: string;
  opt_d: string;
}

const ExamPortal = () => {
  const navigate = useNavigate();
  const videoRef = useRef<HTMLVideoElement>(null);
  
  const [user, setUser] = useState<any>(null);
  const [camAllowed, setCamAllowed] = useState(false);
  const [questions, setQuestions] = useState<Question[]>([]);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [answers, setAnswers] = useState<Record<number, string>>({});
  const [timeLeft, setTimeLeft] = useState(30 * 60); 
  const [examState, setExamState] = useState<"setup" | "running" | "completed">("setup");
  const [submitting, setSubmitting] = useState(false);

  
  useEffect(() => {
    const sessionUser = sessionStorage.getItem("exam_user");
    if (!sessionUser) {
      navigate("/exam/login");
      return;
    }
    const parsedUser = JSON.parse(sessionUser);
    setUser(parsedUser);
    if (parsedUser.time_left !== undefined) {
      setTimeLeft(parsedUser.time_left);
    }
    
    
    fetch("/backend/exam_api.php?action=get_questions")
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          setQuestions(data.questions);
        } else {
          alert("Failed to load questions.");
        }
      });
  }, [navigate]);

  
  const startCamera = async () => {
    try {
      
      const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
      if (videoRef.current) {
        const video = videoRef.current;
        video.srcObject = stream;
        video.setAttribute('playsinline', 'true');
        video.setAttribute('muted', 'true');
        
        try { await video.play(); } catch (_) {}
      }
      setCamAllowed(true);
      setExamState("running");
    } catch (err) {
      alert("You MUST allow camera access to start the exam.");
    }
  };

  
  useEffect(() => {
    let timer: any;
    if (examState === "running" && timeLeft > 0) {
      timer = setInterval(() => setTimeLeft((prev) => prev - 1), 1000);
    } else if (timeLeft === 0 && examState === "running") {
      submitExam(); 
    }
    return () => clearInterval(timer);
  }, [examState, timeLeft]);

  const handleOptionSelect = (qId: number, opt: string) => {
    setAnswers(prev => ({ ...prev, [qId]: opt }));
  };

  const nextQuestion = () => {
    if (currentIndex < questions.length - 1) {
      setCurrentIndex(prev => prev + 1);
    }
  };

  const submitExam = async () => {
    if (submitting) return;
    setSubmitting(true);
    
    try {
      const res = await fetch("/backend/exam_api.php?action=submit_exam", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          user_id: user.id,
          answers: answers
        }),
      });
      const data = await res.json();
      if (data.success) {
        setExamState("completed");
        
        if (videoRef.current && videoRef.current.srcObject) {
          const tracks = (videoRef.current.srcObject as MediaStream).getTracks();
          tracks.forEach(track => track.stop());
        }
        sessionStorage.removeItem("exam_user");
      } else {
        alert("Error submitting exam: " + data.error);
        setSubmitting(false);
      }
    } catch (err) {
      alert("Network error. Please try submitting again.");
      setSubmitting(false);
    }
  };

  const formatTime = (seconds: number) => {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
  };

  if (examState === "completed") {
    return (
      <div className="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4">
        <motion.div 
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          className="bg-white rounded-2xl shadow-xl p-10 text-center max-w-lg w-full"
        >
          <CheckCircle className="w-20 h-20 text-green-500 mx-auto mb-6" />
          <h1 className="text-3xl font-bold text-slate-800 mb-4">Exam Submitted Successfully!</h1>
          <p className="text-slate-600 text-lg mb-8">
            Thank you for taking the scholarship exam. Your responses have been recorded securely. 
            <br/><br/>
            <strong>We will contact you soon with your results!</strong>
          </p>
          <Button onClick={() => navigate("/")} className="bg-indigo-600 hover:bg-indigo-700 text-white px-8 h-12">
            Return to Homepage
          </Button>
        </motion.div>
      </div>
    );
  }

  if (examState === "setup") {
    return (
      <div className="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4">
        <div className="bg-white rounded-2xl shadow-xl p-8 max-w-lg w-full text-center">
          <Camera className="w-16 h-16 text-indigo-500 mx-auto mb-4" />
          <h2 className="text-2xl font-bold text-slate-800 mb-4">Proctoring Setup</h2>
          <p className="text-slate-600 mb-6">
            This exam is strictly proctored. You must grant camera permissions to proceed. 
            Your camera feed will remain active throughout the 30-minute exam.
          </p>
          <div className="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-lg text-sm text-left mb-6 flex gap-3">
            <AlertTriangle className="w-5 h-5 shrink-0" />
            <p>Do not switch tabs, minimize the window, or look away from the screen. Violation may result in disqualification.</p>
          </div>
          <Button onClick={startCamera} className="w-full h-12 bg-indigo-600 hover:bg-indigo-700 text-white text-lg">
            Allow Camera & Start Exam
          </Button>
        </div>
      </div>
    );
  }

  const currentQ = questions[currentIndex];

  return (
    <div className="min-h-screen bg-slate-100 flex flex-col relative">
      
      <div
        className="fixed top-4 right-4 z-50 bg-black rounded-lg shadow-2xl overflow-hidden border-2 border-indigo-500"
        style={{ width: "160px", height: "120px", display: examState === "running" ? "block" : "none" }}
      >
        <video
          ref={videoRef}
          autoPlay
          playsInline
          muted
          className="w-full h-full object-cover"
        />
        <div className="absolute bottom-1 right-2 flex items-center gap-1 text-xs text-white bg-black/50 px-2 py-0.5 rounded">
          <span className="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
          Proctored
        </div>
      </div>

      
      <header className="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center sticky top-0 z-40">
        <div>
          <h1 className="text-xl font-bold text-slate-800">Scholarship Aptitude Test</h1>
          <p className="text-sm text-slate-500">Candidate: {user?.name}</p>
        </div>
        <div className="mr-[180px] flex items-center gap-2 bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg font-bold text-lg border border-indigo-100">
          <Clock className="w-5 h-5" />
          <span className={timeLeft < 300 ? "text-red-600 animate-pulse" : ""}>
            {formatTime(timeLeft)}
          </span>
        </div>
      </header>

      
      <main className="flex-1 max-w-4xl w-full mx-auto p-6 md:p-10 flex flex-col">
        {questions.length > 0 && currentQ ? (
          <motion.div 
            key={currentIndex}
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            className="bg-white rounded-xl shadow-sm border border-slate-200 p-8 flex-1"
          >
            <div className="flex justify-between items-end mb-8 pb-4 border-b border-slate-100">
              <h2 className="text-lg font-semibold text-indigo-600">Question {currentIndex + 1} of {questions.length}</h2>
            </div>

            <h3 className="text-2xl font-medium text-slate-800 mb-8 leading-relaxed">
              {currentQ.question_text}
            </h3>

            <div className="space-y-4">
              {['a', 'b', 'c', 'd'].map((opt) => {
                const optKey = `opt_${opt}` as keyof Question;
                const isSelected = answers[currentQ.id] === opt.toUpperCase();
                
                return (
                  <div 
                    key={opt}
                    onClick={() => handleOptionSelect(currentQ.id, opt.toUpperCase())}
                    className={`p-4 rounded-lg border-2 cursor-pointer transition-all flex items-center gap-4 ${
                      isSelected 
                        ? 'border-indigo-600 bg-indigo-50 shadow-sm' 
                        : 'border-slate-200 hover:border-indigo-300 hover:bg-slate-50'
                    }`}
                  >
                    <div className={`w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm ${
                      isSelected ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600'
                    }`}>
                      {opt.toUpperCase()}
                    </div>
                    <span className={`text-lg ${isSelected ? 'text-indigo-900 font-medium' : 'text-slate-700'}`}>
                      {currentQ[optKey]}
                    </span>
                  </div>
                );
              })}
            </div>
          </motion.div>
        ) : (
          <div className="flex-1 flex items-center justify-center">
            <div className="w-8 h-8 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
          </div>
        )}

        
        <div className="mt-6 flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-slate-200">
          <div className="text-sm font-medium text-slate-500">
            Answered: {Object.keys(answers).length} / {questions.length}
          </div>
          <div className="flex gap-4">
            {currentIndex < questions.length - 1 ? (
              <Button 
                onClick={nextQuestion}
                className="bg-indigo-600 hover:bg-indigo-700 text-white px-8 h-12 text-lg"
              >
                Next Question
              </Button>
            ) : (
              <Button 
                onClick={submitExam}
                disabled={submitting}
                className="bg-green-600 hover:bg-green-700 text-white px-8 h-12 text-lg shadow-lg shadow-green-200"
              >
                {submitting ? "Submitting..." : "Submit Exam"}
              </Button>
            )}
          </div>
        </div>
      </main>

    </div>
  );
};

export default ExamPortal;
