/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { motion } from "framer-motion";
import { Lock, Mail } from "lucide-react";
import { Button } from "@/components/ui/button";

const ExamLogin = () => {
  const [formData, setFormData] = useState({ email: "", password: "" });
  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState("");
  const navigate = useNavigate();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setErrorMsg("");

    try {
      const res = await fetch("/backend/exam_api.php?action=login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });
      const data = await res.json();
      
      if (data.success) {
        
        sessionStorage.setItem("exam_user", JSON.stringify(data.user));
        navigate("/exam/portal");
      } else {
        setErrorMsg(data.error || "Invalid credentials.");
      }
    } catch (err) {
      setErrorMsg("Network error. Please try again.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="bg-slate-50 min-h-[calc(100vh-80px)] py-12 flex items-center justify-center">
      <div className="container mx-auto px-4 max-w-md">
        <motion.div 
          initial={{ opacity: 0, scale: 0.95 }}
          animate={{ opacity: 1, scale: 1 }}
          className="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100"
        >
          <div className="p-8 text-center border-b border-slate-100">
            <div className="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
              <Lock className="w-8 h-8" />
            </div>
            <h1 className="text-2xl font-bold text-slate-800">Exam Portal Login</h1>
            <p className="text-slate-500 mt-2 text-sm">Enter the credentials sent to your email.</p>
          </div>

          <div className="p-8">
            <form onSubmit={handleSubmit} className="space-y-5">
              {errorMsg && (
                <div className="p-4 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm text-center font-medium">
                  {errorMsg}
                </div>
              )}

              <div>
                <label className="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <div className="relative">
                  <Mail className="absolute left-3 top-3 text-gray-400 w-5 h-5" />
                  <input 
                    type="email" 
                    required 
                    value={formData.email}
                    onChange={(e) => setFormData({...formData, email: e.target.value})}
                    className="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 outline-none"
                    placeholder="john@example.com"
                  />
                </div>
              </div>
              
              <div>
                <label className="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <div className="relative">
                  <Lock className="absolute left-3 top-3 text-gray-400 w-5 h-5" />
                  <input 
                    type="password" 
                    required 
                    value={formData.password}
                    onChange={(e) => setFormData({...formData, password: e.target.value})}
                    className="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 outline-none"
                    placeholder="••••••••"
                  />
                </div>
              </div>

              <Button 
                type="submit" 
                disabled={loading}
                className="w-full h-12 bg-indigo-600 hover:bg-indigo-700 text-white text-lg mt-4 shadow-lg shadow-indigo-200"
              >
                {loading ? "Authenticating..." : "Start Exam"}
              </Button>

              <div className="text-center mt-6">
                <Link to="/scholarship" className="text-indigo-600 font-medium hover:underline text-sm">
                  Don't have an account? Register here
                </Link>
              </div>
            </form>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default ExamLogin;
