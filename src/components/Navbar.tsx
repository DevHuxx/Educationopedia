/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { useState } from "react";
import { Link, useLocation } from "react-router-dom";
import { Menu, X, Phone, ChevronDown } from "lucide-react";
import { Button } from "@/components/ui/button";
import logo from "@/assets/logo.png";

const navLinks = [
  { label: "Home", path: "/" },
  {
    label: "Courses",
    path: "/courses",
    children: [
      { label: "MBBS", path: "/courses/mbbs" },
      { label: "Nursing", path: "/courses/nursing" },
      { label: "Pharmacy", path: "/courses/pharmacy" },
      { label: "Dentistry", path: "/courses/dentistry" },
    ],
  },
  {
    label: "Countries",
    path: "/countries",
    children: [
      { label: "Study in Russia", path: "/countries/russia" },
      { label: "Study in Georgia", path: "/countries/georgia" },
      { label: "Study in Kazakhstan", path: "/countries/kazakhstan" },
      { label: "Study in Uzbekistan", path: "/countries/uzbekistan" },
      { label: "Study in Kyrgyzstan", path: "/countries/kyrgyzstan" },
      { label: "Study in Bangladesh", path: "/countries/bangladesh" },
      { label: "Study in Iran", path: "/countries/iran" },
      { label: "Study in Nepal", path: "/countries/nepal" },
      { label: "Study in China", path: "/countries/china" },
      { label: "Study in Lithuania", path: "/countries/lithuania" },
      { label: "Study in the UK", path: "/countries/uk" },
      { label: "Study in Malaysia", path: "/countries/malaysia" },
      { label: "Study in Malta", path: "/countries/malta" },
    ],
  },
  { label: "Universities", path: "/universities" },
  { label: "About", path: "/about" },
  { label: "Blog", path: "/blog" },
  { label: "Gallery", path: "/gallery" },
  { label: "Contact", path: "/contact" },
];

const Navbar = () => {
  const [mobileOpen, setMobileOpen] = useState(false);
  const [openDropdown, setOpenDropdown] = useState<string | null>(null);
  const location = useLocation();

  const isActive = (path: string) => location.pathname === path;

  if (location.pathname === "/exam/portal") return null;

  return (
    <header className="sticky top-0 z-50 bg-card/95 backdrop-blur-md border-b border-border shadow-card">
      <div className="container mx-auto flex items-center justify-between h-16 px-2 md:px-4">
        <Link to="/" className="flex items-center gap-1 md:gap-2 flex-shrink-0">
          <img src={logo} alt="Educationopedia" className="h-8 w-8 md:h-10 md:w-10 object-contain" />
          <span className="text-lg md:text-xl 2xl:text-2xl font-black tracking-tight text-foreground" style={{ fontFamily: "'Outfit', sans-serif", letterSpacing: '-0.01em' }}>
            EDUCATION<span className="text-primary">OPEDIA</span>
          </span>
        </Link>

        
        <nav className="hidden xl:flex items-center gap-0.5 2xl:gap-1">
          {navLinks.map((link) => (
            <div
              key={link.label}
              className="relative group"
              onMouseEnter={() => link.children && setOpenDropdown(link.label)}
              onMouseLeave={() => setOpenDropdown(null)}
            >
              <Link
                to={link.path}
                className={`px-1.5 py-1.5 2xl:px-3 2xl:py-2 text-[13px] 2xl:text-sm font-medium rounded-md transition-colors flex items-center gap-1 whitespace-nowrap ${
                  isActive(link.path)
                    ? "text-primary bg-primary-light"
                    : "text-foreground hover:text-primary hover:bg-primary-light"
                }`}
              >
                {link.label}
                {link.children && <ChevronDown className="h-3 w-3" />}
              </Link>
              {link.children && openDropdown === link.label && (
                <div className={`absolute top-full left-0 bg-card border border-border rounded-lg shadow-elevated py-2 animate-fade-in-up ${
                  link.children.length > 6 ? "grid grid-cols-2 gap-x-2 min-w-[360px] p-3" : "min-w-[200px]"
                }`}>
                  {link.children.map((child) => (
                    <Link
                      key={child.path}
                      to={child.path}
                      className="block px-4 py-2 text-sm text-foreground hover:text-primary hover:bg-primary-light rounded-md transition-colors"
                    >
                      {child.label}
                    </Link>
                  ))}
                </div>
              )}
            </div>
          ))}
        </nav>

        <div className="hidden xl:flex items-center gap-2 2xl:gap-4 flex-shrink-0">
          <a href="tel:+918591342044" className="flex items-center gap-1 text-[13px] 2xl:text-[15px] font-bold text-primary bg-primary/10 px-2.5 py-1.5 2xl:px-3 2xl:py-1.5 rounded-full hover:bg-primary/20 transition-all duration-300 whitespace-nowrap">
            <Phone className="h-3 w-3 2xl:h-4 2xl:w-4 animate-pulse" />
            +91 85913 42044
          </a>
          <Link to="/contact">
            <Button className="bg-primary text-primary-foreground font-heading font-bold text-[13px] 2xl:text-sm h-8 2xl:h-10 px-3 2xl:px-4 shadow-lg shadow-primary/40 hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/60 transition-all duration-300 whitespace-nowrap">
              Free Counselling
            </Button>
          </Link>
        </div>

        
        <button
          className="xl:hidden p-2 text-foreground"
          onClick={() => setMobileOpen(!mobileOpen)}
        >
          {mobileOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
        </button>
      </div>

      
      {mobileOpen && (
        <div className="xl:hidden bg-card border-t border-border animate-fade-in-up">
          <nav className="flex flex-col p-4 gap-1">
            {navLinks.map((link) => (
              <div key={link.label}>
                <Link
                  to={link.path}
                  onClick={() => setMobileOpen(false)}
                  className={`block px-3 py-2 rounded-md text-sm font-medium ${
                    isActive(link.path)
                      ? "text-primary bg-primary-light"
                      : "text-foreground hover:text-primary"
                  }`}
                >
                  {link.label}
                </Link>
                {link.children && (
                  <div className="ml-4">
                    {link.children.map((child) => (
                      <Link
                        key={child.path}
                        to={child.path}
                        onClick={() => setMobileOpen(false)}
                        className="block px-3 py-1.5 text-sm text-muted-foreground hover:text-primary"
                      >
                        {child.label}
                      </Link>
                    ))}
                  </div>
                )}
              </div>
            ))}
            <div className="mt-4 flex flex-col gap-3">
              <a href="tel:+918591342044" className="flex items-center justify-center gap-2 text-base font-bold text-primary bg-primary/10 px-4 py-3 rounded-xl hover:bg-primary/20 transition-all duration-300">
                <Phone className="h-4 w-4 animate-pulse" />
                +91 85913 42044
              </a>
              <Link to="/contact" onClick={() => setMobileOpen(false)}>
                <Button className="w-full h-12 text-base bg-primary text-primary-foreground font-heading font-bold shadow-lg shadow-primary/40 hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/60 transition-all duration-300">
                  Free Counselling
                </Button>
              </Link>
            </div>
          </nav>
        </div>
      )}
    </header>
  );
};

export default Navbar;
