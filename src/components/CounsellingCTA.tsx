/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { Link } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { ArrowRight, GraduationCap, Phone, Shield, Clock } from "lucide-react";

const CounsellingCTA = () => {
  return (
    <section className="py-20 gradient-warm relative overflow-hidden">
      <div className="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDE0djhhMiAyIDAgMCAxLTIgMmgtOGEyIDIgMCAwIDEtMi0ydi04YTIgMiAwIDAgMSAyLTJoOGEyIDIgMCAwIDEgMiAyeiIvPjwvZz48L2c+PC9zdmc+')] opacity-30" />
      <div className="container mx-auto px-4 relative">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="text-center lg:text-left">
            <div className="inline-flex items-center gap-2 bg-primary-foreground/20 rounded-full px-4 py-2 mb-6">
              <GraduationCap className="h-5 w-5 text-primary-foreground" />
              <span className="text-sm font-medium text-primary-foreground">Start Your Study Abroad Journey Today</span>
            </div>
            <h2 className="font-heading text-3xl md:text-5xl font-bold text-primary-foreground mb-4">
              Build a Global Future for Your Child
            </h2>
            <p className="text-primary-foreground/80 text-lg max-w-xl mb-8">
              Don’t let marks or high fees stop the dream. Talk to our experts who have already helped 1,500+ students study abroad — <strong className="text-primary-foreground">100% free, zero pressure.</strong>
            </p>
            <div className="flex flex-col sm:flex-row gap-4">
              <Link to="/contact">
                <Button size="lg" className="bg-card text-foreground hover:bg-card/90 font-heading font-semibold text-base px-8 py-6 shadow-elevated w-full sm:w-auto">
                  Book Free Counselling <ArrowRight className="ml-2 h-5 w-5" />
                </Button>
              </Link>
              <a href="tel:+918591342044">
                <Button size="lg" variant="outline" className="border-2 border-primary-foreground text-primary-foreground bg-primary-foreground/10 hover:bg-primary-foreground/20 font-heading font-semibold text-base px-8 py-6 w-full sm:w-auto">
                  <Phone className="mr-2 h-5 w-5" /> Call Now
                </Button>
              </a>
            </div>
          </div>
          <div className="grid grid-cols-2 gap-4">
            {[
              { icon: Shield, label: "100% Free", desc: "No hidden charges" },
              { icon: Clock, label: "24hr Response", desc: "Quick support" },
              { icon: GraduationCap, label: "Trusted Universities", desc: "Verified & approved" },
              { icon: Phone, label: "Direct Support", desc: "+91 85913 42044" },
            ].map((item) => (
              <div key={item.label} className="p-5 rounded-xl bg-primary-foreground/10 backdrop-blur-sm text-center">
                <item.icon className="h-8 w-8 mx-auto mb-2 text-primary-foreground" />
                <div className="font-heading font-semibold text-primary-foreground text-sm">{item.label}</div>
                <div className="text-xs text-primary-foreground/70 mt-1">{item.desc}</div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
};

export default CounsellingCTA;
