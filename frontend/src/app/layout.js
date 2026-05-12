import './globals.css'
import Link from 'next/link'

export const metadata = {
  title: 'Three Level Password Authentication',
  description: 'Three Level Password Authentication System',
}

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body>
        <ul className="navbar">
          <li><Link href="/">Home</Link></li>
          <li><Link href="/about">About</Link></li>
          <li><Link href="/signup">Sign up</Link></li>
          <li><Link href="/login">Login</Link></li>
        </ul>
        {children}
      </body>
    </html>
  )
}
