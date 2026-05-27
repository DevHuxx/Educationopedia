/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState, useEffect } from "react";
import { fetchContent, submitLead } from "@/lib/api";
import { motion } from "framer-motion";
import { Mail, Phone, MapPin, Clock, Send, Shield, Users, GraduationCap } from "lucide-react";
import { Button } from "@/components/ui/button";
import { useToast } from "@/hooks/use-toast";

const Contact = () => {
  const { toast } = useToast();
  const [form, setForm] = useState({ name: "", email: "", phone: "", course: "", message: "" });
  const [loading, setLoading] = useState(false);
  const [cmsData, setCmsData] = useState<any>(null);

  useEffect(() => {
    fetchContent('contact').then(res => {
      if (res) setCmsData(res);
    });
  }, []);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    try {
      const data = await submitLead(form);
      if (data?.success) {
        toast({ title: "Message Sent!", description: data.message || "Our counsellor will contact you within 24 hours." });
        setForm({ name: "", email: "", phone: "", course: "", message: "" });
      } else {
        toast({ title: "Error", description: data?.error || "Failed to submit enquiry.", variant: "destructive" });
      }
    } catch (err) {
      toast({ title: "Error", description: "Network error. Please try again.", variant: "destructive" });
    } finally {
      setLoading(false);
    }
  };

  const contactInfo = [
    { icon: MapPin, label: "Address", value: cmsData?.address || "Office No- 1103, 11th Floor, GDITL Tower, B-08, Block- C, Netaji Subhash Place, Pitampura, New Delhi - 110034" },
    { icon: Phone, label: "Phone", value: cmsData?.phone_1 || "+91 85913 42044", href: cmsData?.phone_1 ? `tel:${cmsData.phone_1.replace(/\s+/g, '')}` : "tel:+918591342044" },
    { icon: Phone, label: "Phone 2", value: cmsData?.phone_2, href: cmsData?.phone_2 ? `tel:${cmsData.phone_2.replace(/\s+/g, '')}` : undefined },
    { icon: Phone, label: "Phone 3", value: cmsData?.phone_3, href: cmsData?.phone_3 ? `tel:${cmsData.phone_3.replace(/\s+/g, '')}` : undefined },
    { icon: Phone, label: "Phone 4", value: cmsData?.phone_4, href: cmsData?.phone_4 ? `tel:${cmsData.phone_4.replace(/\s+/g, '')}` : undefined },
    { icon: Mail, label: "Email", value: cmsData?.email_1 || "admissions@educationopedia.com", href: cmsData?.email_1 ? `mailto:${cmsData.email_1}` : "mailto:admissions@educationopedia.com" },
    { icon: Mail, label: "General Enquiry", value: cmsData?.email_2 || "contact@educationopedia.com", href: cmsData?.email_2 ? `mailto:${cmsData.email_2}` : "mailto:contact@educationopedia.com" },
    { icon: Clock, label: "Working Hours", value: cmsData?.working_hours || "Mon - Sat: 9:00 AM - 7:00 PM" },
  ].filter(item => item.value);

  return (
    <div>
      <section className="gradient-hero py-20">
        <div className="container mx-auto px-4 text-center">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
            <h1 className="font-heading text-4xl md:text-5xl font-bold text-primary-foreground mb-4">
              {cmsData?.title || "Contact Us"}
            </h1>
            <p className="text-primary-foreground/80 text-lg">
              {cmsData?.subtitle || "Get free expert counselling for your MBBS abroad journey"}
            </p>
          </motion.div>
        </div>
      </section>

      
      <section className="py-4 bg-accent/10 border-b border-border">
        <div className="container mx-auto px-4">
          <div className="flex flex-wrap justify-center gap-8 text-sm text-foreground">
            <div className="flex items-center gap-2"><Shield className="h-4 w-4 text-primary" /> 100% Free Counselling</div>
            <div className="flex items-center gap-2"><Users className="h-4 w-4 text-primary" /> 1500+ Students Placed</div>
            <div className="flex items-center gap-2"><GraduationCap className="h-4 w-4 text-primary" /> NMC/WHO Approved Universities</div>
          </div>
        </div>
      </section>

      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            
            <div className="space-y-6">
              <h2 className="font-heading text-2xl font-bold text-foreground">Get In Touch</h2>
              <p className="text-muted-foreground">Fill out the form or reach us through the details below.</p>
              
              {contactInfo.map((item, idx) => (
                <div key={idx} className="flex items-start gap-4 p-4 rounded-xl bg-card border border-border">
                  <div className="p-2 rounded-lg bg-primary/10">
                    <item.icon className="h-5 w-5 text-primary" />
                  </div>
                  <div>
                    <div className="text-sm font-medium text-foreground">{item.label}</div>
                    {item.href ? (
                      <a href={item.href} className="text-sm text-muted-foreground hover:text-primary">{item.value}</a>
                    ) : (
                      <div className="text-sm text-muted-foreground">{item.value}</div>
                    )}
                  </div>
                </div>
              ))}
            </div>

            
            <div className="lg:col-span-2">
              <div className="bg-card rounded-xl border border-border shadow-card p-8">
                <div className="flex items-center gap-3 mb-2">
                  <h3 className="font-heading text-xl font-bold text-foreground">Book Free Counselling Session</h3>
                  <span className="text-xs px-2 py-1 rounded-full bg-accent/20 text-accent font-semibold animate-pulse">Limited Slots</span>
                </div>
                <p className="text-sm text-muted-foreground mb-6">Get expert guidance within 24 hours — no charges, no obligations.</p>
                <form onSubmit={handleSubmit} className="space-y-4">
                  <div className="grid sm:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-foreground mb-1">Full Name *</label>
                      <input
                        type="text"
                        required
                        value={form.name}
                        onChange={(e) => setForm({ ...form, name: e.target.value })}
                        className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground placeholder:text-muted-foreground text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="Your full name"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-foreground mb-1">Email *</label>
                      <input
                        type="email"
                        required
                        value={form.email}
                        onChange={(e) => setForm({ ...form, email: e.target.value })}
                        className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground placeholder:text-muted-foreground text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="your@email.com"
                      />
                    </div>
                  </div>
                  <div className="grid sm:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-foreground mb-1">Phone *</label>
                      <input
                        type="tel"
                        required
                        value={form.phone}
                        onChange={(e) => setForm({ ...form, phone: e.target.value })}
                        className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground placeholder:text-muted-foreground text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="+91 XXXXX XXXXX"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-foreground mb-1">Interested Course</label>
                      <select
                        value={form.course}
                        onChange={(e) => setForm({ ...form, course: e.target.value })}
                        className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                      >
                        <option value="">Select a course</option>
                        <option value="mbbs">MBBS Abroad</option>
                        <option value="engineering">Engineering</option>
                        <option value="management">Management (MBA)</option>
                        <option value="nursing">Nursing</option>
                        <option value="pharmacy">Pharmacy</option>
                        <option value="dentistry">Dentistry</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-foreground mb-1">Message</label>
                    <textarea
                      rows={4}
                      value={form.message}
                      onChange={(e) => setForm({ ...form, message: e.target.value })}
                      className="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground placeholder:text-muted-foreground text-sm focus:outline-none focus:ring-2 focus:ring-primary resize-none"
                      placeholder="Tell us about your requirements..."
                    />
                  </div>
                  <Button
                    type="submit"
                    disabled={loading}
                    className="w-full bg-primary text-primary-foreground hover:bg-primary/90 font-heading font-semibold py-6 text-base"
                  >
                    {loading ? "Sending..." : "Get Free Counselling Now"} <Send className="ml-2 h-4 w-4" />
                  </Button>
                  <p className="text-xs text-center text-muted-foreground">🔒 Your information is 100% secure & confidential</p>
                </form>
              </div>
            </div>
          </div>

          
          <div className="mt-12 max-w-6xl mx-auto">
            <div className="rounded-xl overflow-hidden border border-border shadow-card h-[400px]">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3500.7!2d77.1565!3d28.6955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d03d3a0000001%3A0x1!2sNetaji%20Subhash%20Place%2C%20Pitampura%2C%20New%20Delhi!5e0!3m2!1sen!2sin!4v1700000000000"
                width="100%"
                height="100%"
                style={{ border: 0 }}
                allowFullScreen
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                title="Educationopedia Office Location - Netaji Subhash Place, Pitampura"
              />
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Contact;
