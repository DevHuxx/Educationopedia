/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState, useEffect } from "react";
import { fetchContent, fetchContentAll } from "@/lib/api";
import { motion } from "framer-motion";
import { CheckCircle, Users, GraduationCap, Globe, Trophy, Target, Eye, Heart, FileText, Stamp, Plane, Scale, BookOpen, Wallet } from "lucide-react";
import CounsellingCTA from "@/components/CounsellingCTA";

const About = () => {
  const [aboutData, setAboutData] = useState<Record<string, string>>({});
  const [statsData, setStatsData] = useState<Record<string, string>>({});

  useEffect(() => {
    fetchContentAll(["about", "stats"]).then((data) => {
      if (data) {
        if (data.about) setAboutData(data.about);
        if (data.stats) setStatsData(data.stats);
      }
    });
  }, []);

  return (
    <div>
      <section className="gradient-hero py-20">
        <div className="container mx-auto px-4 text-center">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
            <h1 className="font-heading text-4xl md:text-5xl font-bold text-primary-foreground mb-4">
              {aboutData.title || "About Educationopedia — Your Trusted MBBS Abroad Consultancy"}
            </h1>
            <p className="text-primary-foreground/80 text-lg max-w-2xl mx-auto">
              {aboutData.subtitle || "Helping Indian students achieve their dream of becoming doctors through affordable, transparent, and end-to-end study abroad guidance since 2015."}
            </p>
          </motion.div>
        </div>
      </section>

      
      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">
          <div className="max-w-5xl mx-auto">
            <div className="grid md:grid-cols-2 gap-12 items-center mb-16">
              <div>
                <span className="text-sm font-semibold text-primary uppercase tracking-wider">Our Story</span>
                <h2 className="font-heading text-3xl font-bold text-foreground mt-2 mb-4">
                  {aboutData.story_title || "Empowering Thousands of Students to Study MBBS Abroad Since 2015"}
                </h2>
                <p className="text-foreground/80 leading-relaxed mb-4">
                  {aboutData.story_p1 || "Educationopedia was founded with a simple yet powerful mission — to make quality international medical education accessible to every deserving Indian student. Over the past decade, we have guided thousands of families through the complex journey of studying MBBS abroad, turning NEET disappointments into white coat celebrations."}
                </p>
                <p className="text-foreground/80 leading-relaxed">
                  {aboutData.story_p2 || "Our experienced education counsellors provide personalized, honest guidance at every step — from choosing the right NMC & WHO approved university to visa processing, hostel allotment, and post-arrival support in 45+ countries. We believe that geography and finances should never be a barrier to becoming a doctor."}
                </p>
              </div>
              <div className="grid grid-cols-2 gap-4">
                {[
                  { icon: Trophy, value: statsData.stat_1_value || "10+", label: statsData.stat_1_label || "Years Experience" },
                  { icon: Users, value: statsData.stat_2_value || "1500+", label: statsData.stat_2_label || "Students Placed" },
                  { icon: GraduationCap, value: statsData.stat_3_value || "2000+", label: statsData.stat_3_label || "Partner Universities" },
                  { icon: Globe, value: statsData.stat_4_value || "45+", label: statsData.stat_4_label || "Countries" },
                ].map((stat) => (
                  <div key={stat.label} className="p-5 rounded-xl bg-card border border-border shadow-card text-center">
                    <stat.icon className="h-8 w-8 mx-auto mb-2 text-primary" />
                    <div className="font-heading text-2xl font-bold text-foreground">{stat.value}</div>
                    <div className="text-xs text-muted-foreground">{stat.label}</div>
                  </div>
                ))}
              </div>
            </div>

            
            <div className="grid md:grid-cols-3 gap-6 mb-16">
              {[
                {
                  icon: Target,
                  title: "Our Mission",
                  desc: "To guide students towards the right path for their study abroad journey with clear, honest, and personalized support. We help students choose the right course, university, and country based on their academic background, budget, and career goals — making international MBBS education simple, affordable, and stress-free."
                },
                {
                  icon: Eye,
                  title: "Our Vision",
                  desc: "To become one of the most trusted and reliable names in MBBS abroad and study abroad consulting. We aim to help students from all backgrounds access global education opportunities, build a strong network of successful medical graduates worldwide, and make international education accessible and affordable for every aspiring doctor."
                },
                {
                  icon: Heart,
                  title: "Our Values",
                  desc: "Transparency in fees and processes, a Student-First approach in every decision, complete end-to-end support from admission to graduation, and building long-term trust with families. We provide continuous assistance even after students reach their destination because our responsibility doesn't end with admission."
                },
              ].map((item) => (
                <div key={item.title} className="p-6 rounded-xl bg-card border border-border shadow-card">
                  <item.icon className="h-10 w-10 text-primary mb-4" />
                  <h3 className="font-heading text-xl font-bold text-foreground mb-3">{item.title}</h3>
                  <p className="text-sm text-foreground/80 leading-relaxed">{item.desc}</p>
                </div>
              ))}
            </div>

            
            <div className="mb-16">
              <div className="text-center mb-10">
                <span className="text-sm font-semibold text-primary uppercase tracking-wider">Complete End-to-End Support</span>
                <h2 className="font-heading text-3xl font-bold text-foreground mt-2">Our Services for MBBS Abroad & Study Abroad Students</h2>
                <p className="text-muted-foreground mt-3 max-w-2xl mx-auto">From the initial counselling session to settling in a new country — everything under one roof.</p>
              </div>
              <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {[
                  {
                    icon: BookOpen,
                    title: "Educational Consulting",
                    items: ["Career counselling & profile evaluation", "Country & university selection", "Course guidance based on career goals", "MBBS Abroad & Study Abroad consultation"]
                  },
                  {
                    icon: FileText,
                    title: "Admission & Documentation",
                    items: ["Admission, Invitation & Rector's Letter", "Ministry Order processing", "Notary & translation of documents", "Authentication from Ministry of External Affairs"]
                  },
                  {
                    icon: Stamp,
                    title: "Visa & Immigration Assistance",
                    items: ["Visa appointment scheduling", "Visa documentation support", "Dedicated immigration lawyer", "Police verification support"]
                  },
                  {
                    icon: Wallet,
                    title: "Financial & Banking Support",
                    items: ["Foreign exchange assistance", "Bank account opening abroad", "Bank deposit for TRC", "Education loan assistance"]
                  },
                  {
                    icon: Plane,
                    title: "Pre-Departure & Post-Arrival",
                    items: ["Airport pickup & drop", "Hostel allotment", "Medical check-up assistance", "Free SIM card & local support"]
                  },
                  {
                    icon: Scale,
                    title: "Legal & Compliance Support",
                    items: ["Dedicated immigration lawyer", "TRC processing & extensions", "Police verification", "Legal documentation support"]
                  },
                ].map((service) => (
                  <motion.div
                    key={service.title}
                    initial={{ opacity: 0, y: 20 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    className="p-6 rounded-xl bg-card border border-border shadow-card"
                  >
                    <service.icon className="h-8 w-8 text-primary mb-3" />
                    <h3 className="font-heading text-lg font-bold text-foreground mb-3">{service.title}</h3>
                    <ul className="space-y-2">
                      {service.items.map((item) => (
                        <li key={item} className="flex items-start gap-2 text-sm text-foreground/80">
                          <CheckCircle className="h-4 w-4 text-primary flex-shrink-0 mt-0.5" />
                          <span>{item}</span>
                        </li>
                      ))}
                    </ul>
                  </motion.div>
                ))}
              </div>
            </div>

            
            <div>
              <h2 className="font-heading text-3xl font-bold text-foreground text-center mb-8">Why Thousands of Families Trust Educationopedia</h2>
              <div className="grid sm:grid-cols-2 gap-4">
                {[
                  "Complete End-to-End Support — Admission to Graduation",
                  "Only NMC & WHO Approved Universities",
                  "Experienced & Professional Counselling Team",
                  "Transparent Process — No Hidden Charges",
                  "Personalized Guidance for Every Student",
                  "Strong Student Support System Abroad",
                  "IELTS Coaching & Language Preparation",
                  "24/7 Emergency Assistance After Arrival",
                ].map((service) => (
                  <div key={service} className="flex items-center gap-3 p-4 rounded-lg bg-muted">
                    <CheckCircle className="h-5 w-5 text-primary flex-shrink-0" />
                    <span className="text-foreground font-medium">{service}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      <CounsellingCTA />
    </div>
  );
};

export default About;
