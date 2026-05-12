'use client';
import { useState } from 'react';

export default function Signup() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [phone, setPhone] = useState('');
  const [pattern, setPattern] = useState('');
  const [message, setMessage] = useState('');

  const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8080/api';

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessage('');
    try {
      const res = await fetch(`${apiUrl}/signup`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password, phone, pattern })
      });
      const data = await res.json();
      if (res.ok) {
        setMessage('Sign up successful! You can now login.');
        setUsername('');
        setPassword('');
        setPhone('');
        setPattern('');
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
      
      <form className="form-container" onSubmit={handleSubmit}>
        <h2>Sign Up</h2>
        <label>USERNAME:</label>
        <input type="text" value={username} onChange={(e) => setUsername(e.target.value)} required />
        
        <label>PASSWORD (Level 1):</label>
        <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} required />
        
        <label>PHONE (Level 2 OTP):</label>
        <input type="text" value={phone} onChange={(e) => setPhone(e.target.value)} required />
        
        <label>PATTERN CODE (Level 3):</label>
        <input type="password" value={pattern} onChange={(e) => setPattern(e.target.value)} required />
        
        <button type="submit" className="button">Register</button>
        <p>{message}</p>
      </form>
    </div>
  );
}
