  // written by: Wangzhe Chen
  // assisted by: Jinqin Gao
  // debugged by: Siyuan Zhong
public class sigmoid {

	public sigmoid(){
		
	}
	    
	public double calculate(double in) {
	    return (1.0 / (1.0 + Math.exp(-in)));
	}
	    
	public double derivative(double x) {
	    return (x * (1 - x));
	}
}
