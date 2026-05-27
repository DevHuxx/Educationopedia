/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { Link } from "react-router-dom";
import { Mail, Phone, MapPin, Globe } from "lucide-react";
import { useState, useEffect } from "react";
import { fetchContentAll } from "@/lib/api";

const Footer = () => {
  const [data, setData] = useState<any>(null);

  if (window.location.pathname === "/exam/portal") {
    return null;
  }

  useEffect(() => {
    fetchContentAll(['footer', 'contact']).then(res => {
      if (res) setData(res);
    });
  }, []);

  const footer = data?.footer || {};
  const contact = data?.contact || {};

  const socialLinks = [
    { label: "Facebook", url: footer.facebook || "https://educationopedia.com/" },
    { label: "Instagram", url: footer.instagram || "https://educationopedia.com/" },
    { label: "Twitter", url: footer.twitter || "#" },
    { label: "LinkedIn", url: footer.linkedin || "#" },
    { label: "YouTube", url: footer.youtube || "https://educationopedia.com/" },
  ].filter(s => s.url !== "#");

  const phones = [
    contact.phone_1,
    contact.phone_2,
    contact.phone_3,
    contact.phone_4
  ].filter(Boolean);

  const emails = [
    contact.email_1,
    contact.email_2
  ].filter(Boolean);

  return (
    <footer className="gradient-hero text-primary-foreground">
      <div className="container mx-auto px-4 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
          
          <div>
            <h3 className="text-2xl font-black mb-4" style={{ fontFamily: "'Outfit', sans-serif", letterSpacing: '-0.01em' }}>
              EDUCATION<span className="text-accent">OPEDIA</span>
            </h3>
            <p className="text-primary-foreground/80 text-sm leading-relaxed mb-6">
              {footer.description || "India’s trusted study abroad & MBBS consultancy. Your reliable partner for global education with expert guidance from admission to graduation."}
            </p>
            <div className="flex gap-3">
              {socialLinks.map((s) => (
                <a key={s.label} href={s.url} target="_blank" rel="noopener noreferrer" className="p-2 rounded-full bg-primary-foreground/10 hover:bg-primary-foreground/20 transition-colors text-xs font-medium">
                  {s.label.charAt(0)}
                </a>
              ))}
            </div>
          </div>

          
          <div>
            <h4 className="font-heading font-semibold text-lg mb-4">Quick Links</h4>
            <ul className="space-y-2">
              {[
                { label: "About Us", path: "/about" },
                { label: "Courses", path: "/courses" },
                { label: "Universities", path: "/universities" },
                { label: "Countries", path: "/countries" },
                { label: "Blog", path: "/blog" },
                { label: "Gallery", path: "/gallery" },
                { label: "Contact Us", path: "/contact" },
              ].map((link) => (
                <li key={link.path}>
                  <Link to={link.path} className="text-sm text-primary-foreground/70 hover:text-primary-foreground transition-colors">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          
          <div>
            <h4 className="font-heading font-semibold text-lg mb-4">Popular Courses</h4>
            <ul className="space-y-2">
              {["MBBS Abroad", "Engineering", "Management (MBA)", "Nursing", "B.Tech", "Pharmacy"].map((course) => (
                <li key={course}>
                  <Link to="/courses" className="text-sm text-primary-foreground/70 hover:text-primary-foreground transition-colors">
                    {course}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          
          <div>
            <h4 className="font-heading font-semibold text-lg mb-4">Contact Us</h4>
            <ul className="space-y-4">
              <li className="flex items-start gap-3">
                <MapPin className="h-5 w-5 mt-0.5 flex-shrink-0 text-accent" />
                <span className="text-sm text-primary-foreground/80">
                  {footer.address || "Office No- 1103, 11th Floor, GDITL Tower, B-08, Block- C, Netaji Subhash Place, Pitampura, New Delhi - 110034"}
                </span>
              </li>
              {(phones.length > 0 || !data) && (
                <li className="flex items-start gap-3">
                  <Phone className="h-5 w-5 mt-0.5 flex-shrink-0 text-accent" />
                  <div className="flex flex-col gap-1">
                    {phones.length > 0 ? phones.map(p => (
                      <a key={p} href={`tel:${p.replace(/\s+/g, '')}`} className="text-sm text-primary-foreground/80 hover:text-primary-foreground">{p}</a>
                    )) : (
                      <span className="text-sm text-primary-foreground/40 animate-pulse">Loading phone numbers...</span>
                    )}
                  </div>
                </li>
              )}
              {(emails.length > 0 || !data) && (
                <li className="flex items-start gap-3">
                  <Mail className="h-5 w-5 mt-0.5 flex-shrink-0 text-accent" />
                  <div className="flex flex-col gap-1">
                    {emails.length > 0 ? emails.map(e => (
                      <a key={e} href={`mailto:${e}`} className="text-sm text-primary-foreground/80 hover:text-primary-foreground">{e}</a>
                    )) : (
                      <span className="text-sm text-primary-foreground/40 animate-pulse">Loading emails...</span>
                    )}
                  </div>
                </li>
              )}
            </ul>
          </div>
        </div>

        <div className="border-t border-primary-foreground/20 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
          <p className="text-sm text-primary-foreground/60">
            © {new Date().getFullYear()} Educationopedia Pvt. Ltd. All rights reserved.
          </p>
          <div className="flex gap-6">
            <Link to="/about" className="text-xs text-primary-foreground/60 hover:text-primary-foreground">Privacy Policy</Link>
            <Link to="/about" className="text-xs text-primary-foreground/60 hover:text-primary-foreground">Terms & Conditions</Link>
            <Link to="/about" className="text-xs text-primary-foreground/60 hover:text-primary-foreground">Disclaimer</Link>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
