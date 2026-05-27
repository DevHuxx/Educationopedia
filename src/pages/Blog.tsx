/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
import { Link, useParams } from "react-router-dom";
import { motion } from "framer-motion";
import { Calendar, Clock, ArrowRight, ArrowLeft, Tag, BookOpen, Search } from "lucide-react";
import { Button } from "@/components/ui/button";
import CounsellingCTA from "@/components/CounsellingCTA";
import { useState } from "react";

import imgMbbsAbroad from "@/assets/blog-mbbs-abroad.jpg";
import imgNeetScore from "@/assets/blog-neet-score.jpg";
import imgScholarship from "@/assets/blog-scholarship.jpg";
import imgRussia from "@/assets/blog-russia.jpg";
import imgChooseUni from "@/assets/blog-choose-uni.jpg";
import imgVisa from "@/assets/blog-visa.jpg";

const blogPosts = [
  {
    id: "1",
    title: "Top 10 Countries for MBBS Abroad in 2025",
    excerpt: "Discover the most popular and affordable destinations for pursuing MBBS abroad with recognized degrees.",
    image: imgMbbsAbroad,
    content: `Studying MBBS abroad has become an increasingly popular option for Indian students who want quality medical education at affordable fees. Here are the top 10 countries for MBBS abroad in 2025:

**1. Russia** — Russia remains the top choice with NMC-approved universities, affordable fees (₹20-35 lakhs total), and globally recognized MD degrees. Universities like Kazan Federal University and Bashkir State Medical University offer excellent medical programs.

**2. Kazakhstan** — With modern infrastructure and fees starting from ₹15 lakhs, Kazakhstan is a budget-friendly option. Kazakh National Medical University and Astana Medical University are top picks.

**4. Bangladesh** — The nearest international option with similar culture and language. Fees are among the lowest at ₹15-25 lakhs total.

**5. Georgia** — Offers European standard education at Asian prices. Tbilisi State Medical University is particularly well-regarded.

**6. Kyrgyzstan** — The most budget-friendly option with fees as low as ₹12-20 lakhs total. Kyrgyz State Medical Academy is the top choice.

**7. Uzbekistan** — Emerging as a new destination with affordable fees and improving infrastructure.

**8. Nepal** — Close proximity to India makes it convenient, with several recognized medical colleges.

**9. China** — Despite recent challenges, China still offers quality medical education at top universities.

**10. Egypt** — A growing destination with WHO-listed universities and affordable living costs.

**Key Factors to Consider:**
- NMC/WHO Approval
- Medium of instruction
- Total course fees
- Living costs
- Safety and culture
- Clinical training quality

Contact Educationopedia for personalized guidance on choosing the best country and university for your MBBS abroad journey.`,
    date: "March 28, 2026",
    category: "MBBS Abroad",
    readTime: "8 min read",
    author: "Dr. Rajesh Kumar",
  },
  {
    id: "2",
    title: "NEET Score Requirements for Studying MBBS Abroad",
    excerpt: "Complete guide on minimum NEET scores required for admission in different countries for Indian students.",
    image: imgNeetScore,
    content: `Since 2021, NEET qualification has become mandatory for Indian students seeking MBBS admission abroad. Here's your complete guide to NEET requirements:

**Minimum NEET Requirements (2025):**
- General Category: 50th percentile (720 marks, ~137 score needed)
- OBC/SC/ST: 40th percentile
- PwD: 45th percentile

**Country-wise NEET Expectations:**

**Russia:** Minimum qualifying score accepted. Most universities don't require high NEET scores, making it accessible for students scoring 200+.

**Kazakhstan:** Similar to Russia, minimum qualifying score is sufficient. Some top universities may prefer 300+ scores.

**Bangladesh:** Requires NEET qualification. Score of 250+ recommended for top colleges.

**Georgia:** Minimum qualification required. European universities may prefer higher scores.

**Important Points:**
1. NEET is mandatory — no exceptions for studying abroad
2. Eligibility letter from NMC requires NEET scorecard
3. Some countries have their own entrance exams in addition to NEET
4. Private universities may have different cut-offs
5. Always verify current requirements as they change annually

**Documents Required:**
- NEET Score Card
- 10th & 12th Mark Sheets
- Passport
- Migration Certificate
- Medical Certificate

For the latest NEET requirements and personalized university recommendations based on your score, contact our expert counsellors at Educationopedia.`,
    date: "March 25, 2026",
    category: "Admissions",
    readTime: "6 min read",
    author: "Priya Mehta",
  },
  {
    id: "3",
    title: "Scholarship Opportunities for Indian Students Abroad",
    excerpt: "Explore various scholarship programs available for Indian students seeking international education.",
    image: imgScholarship,
    content: `Studying abroad doesn't have to be expensive. Here are the top scholarship opportunities available for Indian students in 2025:

**Government Scholarships:**

1. **National Overseas Scholarship** — For SC students, covers tuition, living allowance, and travel
2. **Maulana Azad National Fellowship** — For minority students pursuing higher education
3. **Central Sector Scheme of Scholarship** — Merit-based for economically weaker sections

**University Scholarships:**

Many partner universities offer merit-based and need-based scholarships:
- **Russia:** Up to 50% tuition waiver at government universities
- **Kazakhstan:** Scholarship programs covering 30-100% tuition
- **Georgia:** Merit scholarships at top medical universities
- 
**International Scholarships:**

1. **WHO Fellowship Programme** — For public health studies
2. **Commonwealth Scholarships** — For studies in Commonwealth countries
3. **Aga Khan Foundation Scholarships** — For developing country students

**Tips for Securing Scholarships:**
- Apply early — many have strict deadlines
- Maintain strong academic records (80%+ in 12th)
- Score well in NEET/entrance exams
- Write compelling personal statements
- Get strong recommendation letters
- Apply to multiple scholarships simultaneously

**Educationopedia Scholarship Support:**
We help students identify and apply for scholarships that match their profile. Our success rate for scholarship applications is over 40%. Contact us for a free scholarship assessment.`,
    date: "March 20, 2026",
    category: "Scholarships",
    readTime: "7 min read",
    author: "Amit Singh",
  },
  {
    id: "4",
    title: "Complete Guide to MBBS in Russia 2025",
    excerpt: "Everything you need to know about studying medicine in Russia — fees, universities, admission process, and more.",
    image: imgRussia,
    content: `Russia is the #1 destination for Indian students pursuing MBBS abroad. Here's your comprehensive guide:

**Why Russia for MBBS?**
- NMC & WHO approved universities
- Affordable tuition fees (₹3-6 lakhs/year)
- No entrance exam (apart from NEET qualification)
- English medium of instruction
- Globally recognized MD degree
- Rich cultural experience

**Top Medical Universities in Russia:**
1. Kazan Federal University — Top 200 globally
2. Bashkir State Medical University — 100+ years of excellence
3. Crimea Federal University — Modern facilities
4. Orenburg State Medical University — Strong clinical training
5. Volgograd State Medical University — Research-focused

**Fee Structure (Total 6 Years):**
- Tuition: ₹18-30 lakhs
- Hostel: ₹3-5 lakhs
- Living Expenses: ₹5-8 lakhs
- Total: ₹26-43 lakhs approximately

**Admission Process:**
1. Check eligibility (NEET qualification, 50% in PCB)
2. Choose university with expert guidance
3. Submit application and documents
4. Receive admission letter
5. Apply for visa
6. Pre-departure orientation
7. Travel and enrollment

**Living in Russia:**
- Indian mess/food available near most universities
- Comfortable hostel accommodation
- -20°C to +30°C climate range
- Safe student cities
- Active Indian student communities

Contact Educationopedia for step-by-step assistance with your MBBS in Russia application.`,
    date: "March 15, 2026",
    category: "MBBS Abroad",
    readTime: "10 min read",
    author: "Dr. Rajesh Kumar",
  },
  {
    id: "5",
    title: "How to Choose the Right Medical University Abroad",
    excerpt: "Key factors to consider when selecting a medical university for studying MBBS abroad.",
    image: imgChooseUni,
    content: `Choosing the right medical university abroad is crucial for your career. Here's a detailed guide:

**Factor 1: Recognition & Accreditation**
- Check NMC (National Medical Commission) approval
- Verify WHO listing
- Look for ECFMG certification eligibility
- Confirm the degree is valid for FMGE/NEXT exam

**Factor 2: Faculty & Teaching Quality**
- Student-to-teacher ratio
- Faculty qualifications and experience
- Teaching methodology (lectures, practicals, clinical)
- Language of instruction

**Factor 3: Infrastructure**
- Modern laboratories and equipment
- Teaching hospital facilities
- Library and digital resources
- Hostel and campus amenities

**Factor 4: Clinical Training**
- Hospital bed capacity
- Variety of clinical cases
- Duration of clinical rotations
- Hands-on training opportunities

**Factor 5: Fees & Affordability**
- Compare total cost (tuition + living + extras)
- Check for hidden charges
- Scholarship availability
- Payment plans and flexibility

**Factor 6: Student Support**
- Indian student community
- Indian food availability
- Airport pickup services
- Cultural activities and student organizations

**Red Flags to Watch For:**
❌ Universities not listed on NMC website
❌ Agents promising guaranteed admission without NEET
❌ Extremely low fees that seem too good to be true
❌ No proper website or verifiable contact information

At Educationopedia, we only recommend verified, NMC-approved universities. Book a free counselling session for personalized university recommendations.`,
    date: "March 10, 2026",
    category: "Guidance",
    readTime: "8 min read",
    author: "Priya Mehta",
  },
  {
    id: "6",
    title: "Visa Process for Medical Students Going Abroad",
    excerpt: "Step-by-step guide to the student visa application process for different countries.",
    image: imgVisa,
    content: `The visa process can seem daunting, but with proper guidance, it's straightforward. Here's your complete guide:

**General Documents Required:**
1. Valid passport (minimum 2 years validity)
2. University admission/invitation letter
3. NEET scorecard
4. 10th & 12th mark sheets (originals + copies)
5. Passport-size photographs (as per country specifications)
6. Medical certificate & HIV test report
7. Police clearance certificate
8. Bank statement showing sufficient funds
9. Visa application form

**Country-Specific Requirements:**

**Russia:**
- Invitation letter from university (takes 30-45 days)
- HIV test not older than 3 months
- Processing time: 2-3 weeks
- Visa fee: ~₹5,000-8,000

**Kazakhstan:**
- Letter of invitation from university
- Processing time: 2-3 weeks
- Visa fee: ~₹4,000-6,000

- Student visa (9F) required
- ACR-I Card after arrival
- Processing time: 3-4 weeks

**Georgia:**
- Visa-free for short stay, study permit needed
- Processing time: 2-3 weeks
- Relatively easier process

**Tips for Smooth Visa Processing:**
✅ Start the process at least 2 months before departure
✅ Ensure all documents are properly attested
✅ Maintain sufficient bank balance
✅ Attend visa interview (if required) with confidence
✅ Keep multiple copies of all documents

Educationopedia handles the entire visa process for you — from documentation to embassy appointment booking. Contact us for hassle-free visa assistance.`,
    date: "March 5, 2026",
    category: "Visa Guide",
    readTime: "7 min read",
    author: "Amit Singh",
  },
];

const categories = ["All", "MBBS Abroad", "Admissions", "Scholarships", "Guidance", "Visa Guide"];

const Blog = () => {
  const { postId } = useParams();
  const [selectedCategory, setSelectedCategory] = useState("All");
  const [searchQuery, setSearchQuery] = useState("");

  const filteredPosts = blogPosts.filter((post) => {
    const matchCategory = selectedCategory === "All" || post.category === selectedCategory;
    const matchSearch = post.title.toLowerCase().includes(searchQuery.toLowerCase()) || post.excerpt.toLowerCase().includes(searchQuery.toLowerCase());
    return matchCategory && matchSearch;
  });

  
  if (postId) {
    const post = blogPosts.find((p) => p.id === postId);
    if (!post) {
      return (
        <div className="min-h-screen flex items-center justify-center bg-background">
          <div className="text-center">
            <h1 className="font-heading text-2xl font-bold text-foreground mb-4">Blog post not found</h1>
            <Link to="/blog">
              <Button className="bg-primary text-primary-foreground">Back to Blog</Button>
            </Link>
          </div>
        </div>
      );
    }

    return (
      <div>
        <section className="gradient-hero py-16">
          <div className="container mx-auto px-4">
            <Link to="/blog" className="inline-flex items-center gap-2 text-primary-foreground/70 hover:text-primary-foreground mb-6 text-sm">
              <ArrowLeft className="h-4 w-4" /> Back to Blog
            </Link>
            <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
              <div className="flex items-center gap-3 mb-4">
                <span className="text-xs px-3 py-1 rounded-full bg-primary-foreground/20 text-primary-foreground font-medium">{post.category}</span>
                <span className="text-xs text-primary-foreground/60">{post.readTime}</span>
              </div>
              <h1 className="font-heading text-3xl md:text-4xl font-bold text-primary-foreground mb-4 max-w-3xl">{post.title}</h1>
              <div className="flex items-center gap-4 text-sm text-primary-foreground/70">
                <span>By {post.author}</span>
                <span className="flex items-center gap-1"><Calendar className="h-3.5 w-3.5" /> {post.date}</span>
              </div>
            </motion.div>
          </div>
        </section>

        
        <div className="container mx-auto px-4 -mt-8 relative z-10">
          <div className="max-w-3xl mx-auto">
            <img src={post.image} alt={post.title} className="w-full h-64 md:h-80 object-cover rounded-xl shadow-elevated" loading="lazy" width={800} height={512} />
          </div>
        </div>

        <section className="py-16 bg-background">
          <div className="container mx-auto px-4">
            <div className="max-w-3xl mx-auto">
              <article className="prose prose-sm max-w-none">
                {post.content.split('\n\n').map((paragraph, i) => (
                  <div key={i} className="mb-4">
                    {paragraph.startsWith('**') && paragraph.endsWith('**') ? (
                      <h3 className="font-heading text-xl font-bold text-foreground mt-6 mb-3">
                        {paragraph.replace(/\*\*/g, '')}
                      </h3>
                    ) : paragraph.startsWith('**') ? (
                      <p className="text-foreground/80 leading-relaxed" dangerouslySetInnerHTML={{
                        __html: paragraph
                          .replace(/\*\*(.*?)\*\*/g, '<strong class="text-foreground">$1</strong>')
                          .replace(/❌/g, '<span class="text-destructive">❌</span>')
                          .replace(/✅/g, '<span class="text-primary">✅</span>')
                      }} />
                    ) : paragraph.match(/^\d+\./) || paragraph.startsWith('-') || paragraph.startsWith('❌') || paragraph.startsWith('✅') ? (
                      <p className="text-foreground/80 leading-relaxed pl-4" dangerouslySetInnerHTML={{
                        __html: paragraph
                          .replace(/\*\*(.*?)\*\*/g, '<strong class="text-foreground">$1</strong>')
                          .replace(/❌/g, '<span class="text-destructive">❌</span>')
                          .replace(/✅/g, '<span class="text-primary">✅</span>')
                      }} />
                    ) : (
                      <p className="text-foreground/80 leading-relaxed" dangerouslySetInnerHTML={{
                        __html: paragraph.replace(/\*\*(.*?)\*\*/g, '<strong class="text-foreground">$1</strong>')
                      }} />
                    )}
                  </div>
                ))}
              </article>

              
              <div className="mt-10 p-6 rounded-xl bg-primary/5 border border-primary/20 text-center">
                <h3 className="font-heading text-lg font-bold text-foreground mb-2">Need Expert Guidance?</h3>
                <p className="text-sm text-muted-foreground mb-4">Get free counselling from Educationopedia's MBBS abroad experts</p>
                <Link to="/contact">
                  <Button className="bg-primary text-primary-foreground hover:bg-primary/90 font-heading">
                    Book Free Counselling <ArrowRight className="ml-2 h-4 w-4" />
                  </Button>
                </Link>
              </div>

              
              <div className="mt-16 pt-8 border-t border-border">
                <h3 className="font-heading text-xl font-bold text-foreground mb-6">Related Articles</h3>
                <div className="grid sm:grid-cols-2 gap-4">
                  {blogPosts.filter((p) => p.id !== postId).slice(0, 2).map((p) => (
                    <Link key={p.id} to={`/blog/${p.id}`} className="flex gap-4 p-4 rounded-xl bg-card border border-border hover:shadow-card transition-all group">
                      <img src={p.image} alt={p.title} className="w-20 h-20 rounded-lg object-cover flex-shrink-0" loading="lazy" width={80} height={80} />
                      <div>
                        <span className="text-xs text-primary font-medium">{p.category}</span>
                        <h4 className="font-heading font-semibold text-foreground group-hover:text-primary transition-colors mt-1 mb-1 text-sm leading-tight">{p.title}</h4>
                        <span className="text-xs text-muted-foreground">{p.date}</span>
                      </div>
                    </Link>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </section>
        <CounsellingCTA />
      </div>
    );
  }

  return (
    <div>
      <section className="gradient-hero py-20">
        <div className="container mx-auto px-4 text-center">
          <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
            <h1 className="font-heading text-4xl md:text-5xl font-bold text-primary-foreground mb-4">Our Blog</h1>
            <p className="text-primary-foreground/80 text-lg max-w-2xl mx-auto mb-8">
              Stay updated with the latest news, guides, and tips on studying abroad
            </p>
            
            <div className="max-w-lg mx-auto relative">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
              <input
                type="text"
                placeholder="Search articles..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full pl-12 pr-4 py-3 rounded-xl bg-card text-foreground placeholder:text-muted-foreground shadow-elevated text-sm focus:outline-none focus:ring-2 focus:ring-accent"
              />
            </div>
          </motion.div>
        </div>
      </section>

      
      <div className="bg-card border-b border-border sticky top-16 z-30">
        <div className="container mx-auto px-4">
          <div className="flex gap-1 overflow-x-auto py-3 no-scrollbar">
            {categories.map((cat) => (
              <button
                key={cat}
                onClick={() => setSelectedCategory(cat)}
                className={`px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-colors ${
                  selectedCategory === cat
                    ? "bg-primary text-primary-foreground"
                    : "text-muted-foreground hover:bg-muted"
                }`}
              >
                {cat}
              </button>
            ))}
          </div>
        </div>
      </div>

      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">
          
          {selectedCategory === "All" && !searchQuery && (
            <motion.div initial={{ opacity: 0, y: 20 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
              <Link to={`/blog/${blogPosts[0].id}`} className="block mb-12 rounded-xl bg-card border border-border overflow-hidden hover:shadow-elevated transition-all group">
                <div className="grid md:grid-cols-2">
                  <div className="h-64 md:h-auto relative overflow-hidden">
                    <img src={blogPosts[0].image} alt={blogPosts[0].title} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" width={800} height={512} />
                    <div className="absolute top-4 left-4">
                      <span className="text-xs px-3 py-1 rounded-full bg-primary text-primary-foreground font-medium">Featured</span>
                    </div>
                  </div>
                  <div className="p-8 flex flex-col justify-center">
                    <div className="flex items-center gap-2 mb-3">
                      <span className="text-xs px-2 py-1 rounded-full bg-primary/10 text-primary font-medium">{blogPosts[0].category}</span>
                      <span className="text-xs text-muted-foreground flex items-center gap-1"><Clock className="h-3 w-3" /> {blogPosts[0].readTime}</span>
                    </div>
                    <h2 className="font-heading text-2xl font-bold text-foreground group-hover:text-primary transition-colors mb-3">{blogPosts[0].title}</h2>
                    <p className="text-muted-foreground mb-4">{blogPosts[0].excerpt}</p>
                    <div className="flex items-center gap-4 text-sm text-muted-foreground">
                      <span>By {blogPosts[0].author}</span>
                      <span className="flex items-center gap-1"><Calendar className="h-3.5 w-3.5" /> {blogPosts[0].date}</span>
                    </div>
                  </div>
                </div>
              </Link>
            </motion.div>
          )}

          
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {(selectedCategory === "All" && !searchQuery ? filteredPosts.slice(1) : filteredPosts).map((post, i) => (
              <motion.div
                key={post.id}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.05 }}
              >
                <Link to={`/blog/${post.id}`} className="block rounded-xl bg-card border border-border hover:shadow-elevated transition-all overflow-hidden group h-full">
                  <div className="h-48 relative overflow-hidden">
                    <img src={post.image} alt={post.title} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" width={800} height={512} />
                  </div>
                  <div className="p-6">
                    <div className="flex items-center gap-2 mb-3">
                      <span className="text-xs px-2 py-1 rounded-full bg-primary/10 text-primary font-medium">{post.category}</span>
                      <span className="text-xs text-muted-foreground">{post.readTime}</span>
                    </div>
                    <h3 className="font-heading font-semibold text-foreground group-hover:text-primary transition-colors mb-2">{post.title}</h3>
                    <p className="text-sm text-muted-foreground line-clamp-2 mb-4">{post.excerpt}</p>
                    <div className="flex items-center justify-between text-xs text-muted-foreground">
                      <span>{post.author}</span>
                      <span>{post.date}</span>
                    </div>
                  </div>
                </Link>
              </motion.div>
            ))}
          </div>

          {filteredPosts.length === 0 && (
            <div className="text-center py-12">
              <p className="text-muted-foreground">No articles found matching your search.</p>
            </div>
          )}
        </div>
      </section>
      <CounsellingCTA />
    </div>
  );
};

export default Blog;
