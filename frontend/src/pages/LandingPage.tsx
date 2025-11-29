import Login from "@/components/Login";
import { Button } from "@/components/ui/button";

export default function LandingPage() {
  return (
    <div>
      <section className="relative pt-20 pb-32 overflow-hidden">
        <div className="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-100 via-white to-white opacity-70"></div>
        
        <div className="container mx-auto px-4 text-center sm:px-6">
          <div className="mx-auto max-w-3xl space-y-6">
            <h1 className="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl text-slate-900">
              Smart finance for the <br />
              <span className="text-green-600">young adults.</span>
            </h1>
            <p className="mx-auto max-w-[700px] text-lg text-slate-600 md:text-xl">
              Track expenses, visualize investments, and master your budget with 
              analytics powered by <b>Finance++</b>. The personal finance tool built for efficiency.
            </p>
            <div className="flex flex-col sm:flex-row justify-center gap-4 pt-4">
              <Login>
                <Button className="bg-green-600">
                  Get Started
                </Button>
              </Login>
            </div>
          </div>
        </div>
      </section>
    </div>
  )
}