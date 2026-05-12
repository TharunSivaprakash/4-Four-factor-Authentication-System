'use client';
import { useState } from 'react';

export default function Login() {
  const [step, setStep] = useState(1);
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [otp, setOtp] = useState('');
  const [pattern, setPattern] = useState('');
  const [message, setMessage] = useState('');
  const [step3Token, setStep3Token] = useState('');

  const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8080/api';

  const handleStep1 = async (e) => {
    e.preventDefault();
    setMessage('');
    try {
      const res = await fetch(`${apiUrl}/login/step1`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
      });
      const data = await res.json();
      if (res.ok) {
        setStep(2);
        setMessage(data.message);
      } else {
        setMessage(data);
      }
    } catch (err) {
      setMessage('Error connecting to backend');
    }
  };

  const handleStep2 = async (e) => {
    e.preventDefault();
    setMessage('');
    try {
      const res = await fetch(`${apiUrl}/login/step2`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, otp })
      });
      const data = await res.json();
      if (res.ok) {
        setStep3Token(data.step3Token);
        setStep(3);
        setMessage(data.message);
      } else {
        setMessage(data);
      }
    } catch (err) {
      setMessage('Error connecting to backend');
    }
  };

  const handleStep3 = async (e) => {
    e.preventDefault();
    setMessage('');
    try {
      const res = await fetch(`${apiUrl}/login/step3`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, step3Token, pattern })
      });
      const data = await res.json();
      if (res.ok) {
        setStep(4);
        setMessage(data.message);
      } else {
        setMessage(data);
      }
    } catch (err) {
      setMessage('Error connecting to backend');
    }
  };

  return (
    <div className="center">
      <h1>THREE LEVEL PASSWORD AUTHENTICATION SYSTEM</h1>
      
      {step === 1 && (
        <form className="form-container" onSubmit={handleStep1}>
          <h2>Login - Step 1: Password</h2>
          <label>USERNAME:</label>
          <input type="text" value={username} onChange={(e) => setUsername(e.target.value)} required />
          <label>PASSWORD:</label>
          <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} required />
          <button type="submit" className="button">Submit</button>
          <p>{message}</p>
        </form>
      )}

      {step === 2 && (
        <form className="form-container" onSubmit={handleStep2}>
          <h2>Login - Step 2: OTP</h2>
          <p>An OTP has been sent to your phone (Check backend logs for simulation)</p>
          <label>ENTER OTP:</label>
          <input type="text" value={otp} onChange={(e) => setOtp(e.target.value)} required />
          <button type="submit" className="button">Verify OTP</button>
          <p>{message}</p>
        </form>
      )}

      {step === 3 && (
        <form className="form-container" onSubmit={handleStep3}>
          <h2>Login - Step 3: Pattern</h2>
          <label>ENTER PATTERN CODE:</label>
          <input type="password" value={pattern} onChange={(e) => setPattern(e.target.value)} required />
          <button type="submit" className="button">Verify Pattern</button>
          <p>{message}</p>
        </form>
      )}

      {step === 4 && (
        <div className="form-container">
          <h2>Welcome {username}!</h2>
          <p>{message}</p>
        </div>
      )}
    </div>
  );
}
