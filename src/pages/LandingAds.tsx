/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { Crown, ArrowRight, Award, MapPin, Phone, Mail, X, Check, Globe, GraduationCap, Building2, Users, Info, Trophy } from "lucide-react";
import { Button } from "@/components/ui/button";
import { submitLead } from "@/lib/api";
import { useToast } from "@/hooks/use-toast";

const LandingAds = () => {
  const { toast } = useToast();
  const [loading, setLoading] = useState(false);

  
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    country: "Russia (Legacy Universities)",
    specialization: "",
    motivation: ""
  });

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);

    const result = await submitLead({
      name: formData.name,
      email: formData.email,
      phone: formData.phone,
      country: formData.country,
      message: `Initial interest from LandingAds page.`,
      source: 'landing_ads'
    });

    setLoading(false);
    if (result?.success || result?.message) {
      toast({
        title: "Application Successful!",
        description: "Your registration is complete. Please check your email.",
      });
      setFormData({ name: "", email: "", phone: "", country: "Russia (Legacy Universities)", specialization: "", motivation: "" });
    } else {
      toast({
        title: "Submission Error",
        description: result?.error || "Failed to connect to our counselor. Please call +91 91161 11639.",
        variant: "destructive"
      });
    }
  };

  return (
    <div className="bg-[#f8fafc] text-slate-900 font-['DM_Sans',sans-serif] selection:bg-blue-600/20 overflow-x-hidden">
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap');
        
        .font-heading { font-family: 'Space Grotesk', sans-serif; }
        .text-gradient-primary {
          background: linear-gradient(135deg, #074d6d 0%, #1e40af 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        }
        .hero-mesh {
          background: #003b82;
          position: relative;
          overflow: hidden;
        }
        .hero-curve {
          position: absolute;
          right: -10%;
          top: 10%;
          width: 60%;
          height: 80%;
          background: #42a5f5;
          border-radius: 50%;
          opacity: 0.6;
          filter: blur(100px);
          z-index: 1;
        }
        .glass-card {
          background: rgba(255, 255, 255, 0.95);
          backdrop-filter: blur(10px);
          border: 1px solid rgba(0, 0, 0, 0.05);
          box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.08);
        }
        .btn-shimmer {
          position: relative;
          overflow: hidden;
        }
        .btn-shimmer::after {
          content: '';
          position: absolute;
          top: -50%;
          left: -50%;
          width: 200%;
          height: 200%;
          background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
          transform: rotate(45deg);
          animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
          0% { transform: translateX(-100%) rotate(45deg); }
          100% { transform: translateX(100%) rotate(45deg); }
        }
      `}</style>

      
      <header className="fixed top-0 w-full z-[100] bg-white border-b border-slate-200">
        <div className="container mx-auto px-4 sm:px-8 py-3 sm:py-4 flex justify-between items-center gap-2">
          <div className="flex items-center gap-2 sm:gap-4 flex-shrink-0">
            <img src="/assets/logo-DUbuizEs.png" alt="Educationopedia" className="h-8 w-8 sm:h-10 sm:w-10 object-contain" />
            <div className="flex flex-col">
              <span className="text-[0.95rem] xs:text-[1.1rem] sm:text-2xl font-black tracking-tighter font-heading text-blue-950 leading-none">Educationopedia</span>
              <span className="text-[6px] xs:text-[7px] sm:text-[9px] uppercase tracking-[0.1em] sm:tracking-[0.4em] text-blue-700 font-bold mt-0.5 sm:mt-0">Admissions Portal</span>
            </div>
          </div>
          <div className="hidden lg:flex gap-10 text-[10px] font-bold uppercase tracking-widest text-slate-500">
            <a href="#vision" className="hover:text-blue-900 transition">Our Vision</a>
            <a href="#destinations" className="hover:text-blue-900 transition">Destinations</a>
            <a href="#grants" className="hover:text-blue-900 transition">Merit Grant</a>
          </div>
          <a href="#apply" className="bg-orange-600 text-white px-4 sm:px-8 py-2 sm:py-3 rounded-full font-black text-[9px] sm:text-[11px] uppercase tracking-widest hover:bg-orange-700 transition-all shadow-xl shadow-orange-600/20 whitespace-nowrap flex-shrink-0">Apply 2026</a>
        </div>
      </header>

      
      <section className="hero-mesh min-h-screen flex items-center pt-40 sm:pt-32 pb-12 relative px-6">
        <div className="hero-curve"></div>
        <div className="container mx-auto grid lg:grid-cols-2 gap-12 items-center relative z-10">
          <div className="space-y-8 text-center lg:text-left">
            <motion.h1
              initial={{ opacity: 0, x: -50 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: 0.2 }}
              className="font-heading text-2xl sm:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-white uppercase whitespace-pre-line"
            >
              Turn your dream of becoming a doctor{"\n"}into reality
            </motion.h1>

            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="inline-flex items-center gap-3 bg-orange-600 px-6 sm:px-8 py-3 rounded-xl shadow-lg"
            >
              <span className="text-base sm:text-lg font-black text-white">Get a Scholarship for Your MBBS Abroad!</span>
            </motion.div>

            <motion.p
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              transition={{ delay: 0.4 }}
              className="text-base lg:text-lg text-white font-medium max-w-xl leading-relaxed mx-auto lg:mx-0"
            >
              <span className="hidden lg:inline">Educationopedia brings you an exclusive opportunity to reduce your MBBS abroad cost with a scholarship on hostel fee/mess charges or up to 10% tuition fee discount. Through the DoctorDream111 Scholarship Program, selected students will get hostel expense support or tuition fee benefits based on their talent, performance, and scholarship exam results. Apply now and take one step closer to your medical career.</span>
              <span className="lg:hidden">Reduce your MBBS abroad cost with up to <strong>10% tuition fee discount</strong> or hostel fee support through the DoctorDream111 Scholarship. Apply now!</span>
            </motion.p>
          </div>

          <motion.div
            initial={{ opacity: 0, scale: 0.95 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ delay: 0.5 }}
            className="glass-card p-8 lg:p-12 rounded-[40px] relative overflow-hidden max-w-md mx-auto w-full"
          >
            <div className="mb-8 text-center">
              <h3 className="font-heading text-3xl font-black text-blue-950 mb-2">Register Now</h3>
              <p className="text-slate-500 font-bold text-[10px] uppercase tracking-widest">Secure Your Merit Scholarship Evaluation</p>
            </div>

            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="space-y-2">
                <label className="text-[10px] font-black uppercase tracking-widest text-slate-400 block ml-1">Full Name</label>
                <input
                  type="text"
                  required
                  placeholder="Candidate Name"
                  value={formData.name}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  className="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition-all font-bold text-sm"
                />
              </div>
              <div className="space-y-2">
                <label className="text-[10px] font-black uppercase tracking-widest text-slate-400 block ml-1">Phone Number</label>
                <input
                  type="tel"
                  required
                  placeholder="+91 WhatsApp Number"
                  value={formData.phone}
                  onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                  className="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition-all font-bold text-sm"
                />
              </div>
              <div className="space-y-2">
                <label className="text-[10px] font-black uppercase tracking-widest text-slate-400 block ml-1">Email Address</label>
                <input
                  type="email"
                  required
                  placeholder="name@example.com"
                  value={formData.email}
                  onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                  className="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl focus:ring-2 focus:ring-blue-600 outline-none transition-all font-bold text-sm"
                />
              </div>
              <button
                type="submit"
                disabled={loading}
                className="btn-shimmer w-full bg-orange-600 text-white py-5 rounded-2xl font-black text-lg uppercase tracking-widest shadow-xl shadow-orange-600/30 transform hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3"
              >
                {loading ? "Registering..." : "Apply 2026"}
              </button>
            </form>
          </motion.div>
        </div>
      </section>

      
      <section className="bg-[#f8fafc] py-12 border-b border-slate-200">
        <div className="container mx-auto px-8">
          <div className="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center divide-x divide-slate-200">
            <div className="px-4">
              <span className="block text-4xl font-black text-blue-900 mb-1">1500+</span>
              <span className="text-[10px] uppercase tracking-widest text-blue-700 font-black">Students</span>
            </div>
            <div className="px-4">
              <span className="block text-4xl font-black text-orange-600 mb-1">10+</span>
              <span className="text-[10px] uppercase tracking-widest text-orange-500 font-black">Countries</span>
            </div>
            <div className="px-4">
              <span className="block text-4xl font-black text-blue-900 mb-1">MBBS</span>
              <span className="text-[10px] uppercase tracking-widest text-blue-700 font-black">Experts</span>
            </div>
            <div className="px-4">
              <span className="block text-xl font-black text-orange-600 uppercase tracking-widest leading-tight">Scholarships</span>
            </div>
          </div>
        </div>
      </section>

      
      <section className="py-24 bg-slate-50 border-y border-slate-200">
        <div className="container mx-auto px-8 text-center">
          <div className="inline-block bg-blue-100 text-blue-700 px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-6">
            The Advantage
          </div>
          <h2 className="font-heading text-4xl lg:text-5xl font-black text-blue-950 mb-16 uppercase">Why Choose Doctor Dream111?</h2>
          <div className="grid md:grid-cols-3 gap-12 max-w-6xl mx-auto">
            <div className="bg-white p-10 rounded-[32px] shadow-lg border border-slate-100 flex flex-col items-center hover:shadow-xl transition-all group">
              <div className="w-20 h-20 bg-blue-50 text-blue-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-blue-500/10 group-hover:bg-blue-700 group-hover:text-white transition-all duration-500">
                <Trophy className="w-10 h-10" />
              </div>
              <h3 className="text-2xl font-black text-blue-900 leading-tight mb-4">Merit-Based <br /> Scholarships</h3>
              <p className="text-slate-500 text-sm font-medium leading-relaxed">Top 111 students receive exclusive hostel fee support and grants based on performance.</p>
            </div>
            <div className="bg-white p-10 rounded-[32px] shadow-lg border border-slate-100 flex flex-col items-center hover:shadow-xl transition-all group">
              <div className="w-20 h-20 bg-blue-50 text-blue-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-blue-500/10 group-hover:bg-blue-700 group-hover:text-white transition-all duration-500">
                <Building2 className="w-10 h-10" />
              </div>
              <h3 className="text-2xl font-black text-blue-900 leading-tight mb-4">NMC / MCI <br /> Approved Universities</h3>
              <p className="text-slate-500 text-sm font-medium leading-relaxed">Admission only to world-class medical institutions recognized by global medical boards.</p>
            </div>
            <div className="bg-white p-10 rounded-[32px] shadow-lg border border-slate-100 flex flex-col items-center hover:shadow-xl transition-all group">
              <div className="w-20 h-20 bg-blue-50 text-blue-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-blue-500/10 group-hover:bg-blue-700 group-hover:text-white transition-all duration-500">
                <Users className="w-10 h-10" />
              </div>
              <h3 className="text-2xl font-black text-blue-900 leading-tight mb-4">End-to-End <br /> Support</h3>
              <p className="text-slate-500 text-sm font-medium leading-relaxed">From documentation to airport pickup, we stay with you throughout your 6-year journey.</p>
            </div>
          </div>
        </div>
      </section>

      
      <section id="destinations" className="py-12 lg:py-24 container mx-auto px-4 sm:px-8">
        <div className="flex flex-col lg:flex-row justify-between items-end gap-6 lg:gap-10 mb-10 lg:mb-20">
          <div className="max-w-3xl">
            <span className="text-orange-600 font-black text-[11px] uppercase tracking-[0.4em] mb-3 lg:mb-4 block">Our Reach</span>
            <h2 className="font-heading text-3xl sm:text-4xl lg:text-7xl font-black tracking-tight text-blue-950 leading-[1.1]">Scholarship Available in <br className="hidden sm:block" /> <span className="text-blue-600">Top Partner Universities.</span></h2>
          </div>
          <p className="hidden lg:block text-slate-500 max-w-sm text-sm font-medium leading-relaxed border-l-4 border-blue-900 pl-6 py-2">
            Explore top countries offering world-class medical education with the DoctorDream111 Scholarship.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
          {[
            "Kazan State Medical University",
            "Kazan Federal University",
            "Volgograd State Medical University",
            "Tver State Medical University",
            "Kursk State Medical University",
            "East West University",
            "Grigol Robakidze University",
            "East European University",
            "European University",
            "International Black Sea University",
            "Tashkent Medical Academy",
            "Samarkand State Medical University",
            "Bukhara State Medical Institute",
            "Tashkent State Dental Institute",
            "Navoi State University",
            "Birat Medical College",
            "Nobel Medical College Teaching Hospital",
            "B.P. Koirala Institute (BPKIHS)",
            "Manipal College of Medical Sciences",
            "Semey Medical University"
          ].map((uni, idx) => (
            <div key={idx} className="bg-slate-50 border border-slate-200 rounded-2xl p-5 sm:p-6 hover:shadow-md hover:border-slate-300 transition-all duration-300 flex items-start gap-3 group">
              <span className="text-orange-500 font-bold mt-0.5 group-hover:translate-x-1 transition-transform">▹</span>
              <p className="text-slate-800 font-bold text-sm sm:text-base leading-snug">
                {uni}
              </p>
            </div>
          ))}
        </div>
      </section>

      
      <section id="grants" className="py-24 bg-blue-900 text-white">
        <div className="container mx-auto px-8">
          <div className="text-center mb-20">
            <h2 className="font-heading text-5xl lg:text-7xl font-black tracking-tight mb-4">Scholarship Benefits.</h2>
            <p className="text-blue-300 font-bold uppercase tracking-[0.3em] text-[10px]">DoctorDream111 Program Advantages</p>
          </div>

          <div className="grid lg:grid-cols-2 gap-16 items-center">
            <div className="space-y-12">
              {[
                { id: "01", title: "Hostel Fees Covered", desc: "(Selected Students Only) Get full or partial hostel fee support based on your merit." },
                { id: "02", title: "Affordable MBBS Abroad", desc: "A unique opportunity to make your medical education highly affordable." },
                { id: "03", title: "Transparent Selection", desc: "A 100% fair, transparent, and merit-based selection process via the scholarship test." },
                { id: "04", title: "Expert Guidance", desc: "End-to-end admission support and expert guidance by Educationopedia." },
                { id: "05", title: "Limited Seats", desc: "This exclusive scholarship is strictly limited to only 111 students." }
              ].map((item, i) => (
                <div key={i} className="flex gap-8 items-start">
                  <span className="font-heading text-4xl font-black text-white/30">{item.id}</span>
                  <div>
                    <h4 className="text-xl font-black mb-2 text-white">{item.title}</h4>
                    <p className="text-blue-200 text-sm leading-relaxed font-medium">{item.desc}</p>
                  </div>
                </div>
              ))}
            </div>
            <div className="relative">
              <div className="absolute -inset-4 bg-orange-600 rounded-[40px] rotate-2 opacity-20"></div>
              <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&q=80&w=1200" className="relative rounded-[40px] shadow-2xl z-10" alt="Excellence" />
            </div>
          </div>
        </div>
      </section>

      
      <section className="py-24 bg-slate-50">
        <div className="container mx-auto px-8">
          <div className="grid lg:grid-cols-2 gap-20">
            
            <div className="bg-white p-12 rounded-[40px] shadow-xl border border-slate-100 relative overflow-hidden">
              <div className="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[100px] -z-0"></div>
              <div className="relative z-10">
                <span className="text-orange-600 font-black text-[10px] uppercase tracking-widest mb-4 block">Requirements</span>
                <h3 className="font-heading text-4xl font-black text-blue-950 mb-10">Eligibility Criteria</h3>
                <ul className="space-y-6">
                  {[
                    "NEET Qualified (Preferred)",
                    "Planning for MBBS Abroad 2026 Intake",
                    "Must appear for the Scholarship Test"
                  ].map((req, i) => (
                    <li key={i} className="flex items-center gap-4">
                      <div className="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0"><Check className="w-4 h-4" /></div>
                      <span className="text-slate-700 font-bold text-lg">{req}</span>
                    </li>
                  ))}
                </ul>
              </div>
            </div>

            
            <div className="bg-blue-950 p-12 rounded-[40px] shadow-2xl relative overflow-hidden text-white">
              <div className="absolute top-0 right-0 w-32 h-32 bg-blue-900 rounded-bl-[100px] -z-0"></div>
              <div className="relative z-10">
                <span className="text-orange-400 font-black text-[10px] uppercase tracking-widest mb-4 block">How it works</span>
                <h3 className="font-heading text-4xl font-black mb-10">Selection Process</h3>
                <div className="space-y-8">
                  {[
                    { step: "1", title: "Register First", desc: "Complete the application form to secure your entry." },
                    { step: "2", title: "Appear for Test", desc: "Take the official DoctorDream111 Scholarship Exam." },
                    { step: "3", title: "Merit Selection", desc: "Profiles and scores are evaluated transparently." },
                    { step: "4", title: "Top 111 Awarded", desc: "The top 111 students receive the hostel scholarship." }
                  ].map((proc, i) => (
                    <div key={i} className="flex gap-6 items-start group">
                      <div className="w-10 h-10 rounded-xl bg-blue-900 flex items-center justify-center font-black text-white shrink-0 group-hover:bg-orange-500 transition-colors">{proc.step}</div>
                      <div>
                        <h4 className="font-bold text-lg mb-1">{proc.title}</h4>
                        <p className="text-blue-200 text-sm font-medium">{proc.desc}</p>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      
      <section className="py-16 bg-slate-900 text-slate-400 border-t border-slate-800">
        <div className="container mx-auto px-8 max-w-4xl">
          <h4 className="text-white font-black uppercase tracking-widest text-sm mb-6 flex items-center gap-2">
            <Info className="w-5 h-5 text-orange-500" /> Terms & Conditions Apply:
          </h4>
          <ul className="list-disc pl-6 space-y-3 text-xs leading-relaxed font-medium">
            <li>Filling out the form does not guarantee a scholarship.</li>
            <li>Scholarship will be granted only after qualifying for the scholarship exam.</li>
            <li>Only registered candidates are eligible for the scholarship test.</li>
            <li>Scholarship is limited to the first 111 selected students based on merit.</li>
            <li>The final decision will be taken by Educationopedia.</li>
          </ul>
        </div>
      </section>

      
      <footer className="py-20 bg-blue-900 text-white">
        <div className="container mx-auto px-8 text-center">
          <h3 className="font-heading text-3xl font-black mb-12 uppercase tracking-widest">
            Your White Coat Journey Starts Here
          </h3>
          <div className="flex items-center justify-center gap-4 mb-8">
            <img src="/assets/logo-DUbuizEs.png" alt="Logo" className="h-10 w-10 object-contain" />
            <span className="text-2xl font-bold font-heading text-white">Educationopedia</span>
          </div>
          <p className="text-blue-200 text-sm max-w-xl mx-auto font-medium leading-relaxed mb-10">
            Trusted since 2015, Educationopedia has guided 4,500+ aspirants to their medical dreams across the globe.
          </p>
          <div className="flex justify-center gap-8 text-blue-300 font-bold uppercase tracking-widest text-[10px]">
            <a href="/contact" className="hover:text-white transition">Contact</a>
            <a href="/about" className="hover:text-white transition">Our Legacy</a>
            <a href="/scholarship" className="hover:text-white transition">Exams</a>
          </div>
          <div className="mt-16 pt-8 border-t border-blue-800 text-blue-400 text-[10px] uppercase tracking-[0.3em]">
            © 2026 Educationopedia Group. All Rights Reserved.
          </div>
        </div>
      </footer>

      
    </div>
  );
};

export default LandingAds;
