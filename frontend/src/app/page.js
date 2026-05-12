import Link from 'next/link';

export default function Home() {
  return (
    <div className="center">
      <br /><br />
      <h1>THREE LEVEL PASSWORD AUTHENTICATION SYSTEM</h1>
      <br /><br /><br /><br />
      <div>
        <Link href="/signup" className="button">
          <span>SIGN UP</span>
        </Link>
        <br /><br />
        <Link href="/login" className="button">
          <span>LOGIN</span>
        </Link>
      </div>
    </div>
  );
}
