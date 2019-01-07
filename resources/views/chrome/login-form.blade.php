<form onSubmit={this.handleSubmit}>

                    <h1>Sign In</h1>
                    
                    <div className="form-group">					
                        <label>Email:</label>
                        <input type="email" className="form-control" name="email" onChange={this.handleChange} required />
                    </div>

                    <div className="form-group">
                        
                        <label>Password:</label>
                        <input type="password" className="form-control" name='password' onChange={this.handleChange} required />

                    </div>

            
                    <div className="form-group">
                        
                        <button type="submit" className="btn btn-primary">Signin</button>

                                               
                        <a href="register.html">Register</a>

                    </div>

                </form>