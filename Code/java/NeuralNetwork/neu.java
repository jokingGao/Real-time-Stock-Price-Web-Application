  // written by: Wangzhe Chen
  // assisted by: Jinqin Gao
  // debugged by: Siyuan Zhong

public class neu {
	int N;
	double []inputs;
	double []weights;
	double error;
	//double biasWeight;

	public neu (int n){ 
		N = n;
		inputs = new double[N];
	    weights = new double[N];

	}

	public double put() {
        double sum = 0;
        for(int i = 0; i < N; i++){
        	sum += weights[i] * inputs[i];
        }
        //sum += biasWeight;
	    sigmoid s = new sigmoid();
        return (s.calculate(sum));
    }
	
	public double derivative(double x) {
        return (x * (1 - x));
    }
	
    public void randomizeWeights() {
    	for(int i = 0; i < N; i++){
    		weights[i] = Math.random()*2-1;
    	}
        //biasWeight = Math.random()*2-1;
    }
    
    public void adjustWeights() {
    	for(int i = 0; i < N; i++){
    		weights[i] += 0.1 * error * inputs[i];
    	}
        //biasWeight += 0.1 * error;
    }
    

}
