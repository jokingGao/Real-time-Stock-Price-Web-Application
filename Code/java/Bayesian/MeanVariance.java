//package Bayesian;
import Jama.*;

public class MeanVariance {
	private double alpha = 0.005;
	private double beta = 11.1;
	private int M = 5;
	private double actual_price;
	private String actual_date;
	public double[] Calculate(double data[], int length, int days, String p[]){
		//first n days
		int n = length;
		//n+1 day
//		actual_price = data[n];
//		actual_date = p[n];
		//price 
		double[] price = new double[n];
		for(int i = n; i > 0; i--){
			int temp = data.length;
			price[n-i] = data[temp-n];
		}
		//x value
		double[] x = new double[n];
		//SumPhi(xn)
		double[][] a = new double[M + 1][1];
		// Phi(x)T
		double[][] b = new double[1][M + 1];
		//SumPhi(x)t
		double[][] c = new double[M + 1][1];
		//I
 		double[][] I = new double[M + 1][M + 1];
 		//S
		double[][] s;
		
		//initialize training data x
		for(int i = 0; i < n; i++){
			x[i] = i + 1;
		}
		
		//initialize SumPhi(xn)
		for(int i = 0; i < n; i++){
            for(int j = 0; j <= M; j++){
                a[j][0] += Math.pow(x[i], j);
            }
        }
		
		//initialize Phi(x)T
		for(int i = 0; i <= M; i++){
            b[0][i] = Math.pow(x[n-1]+days, i);
        }
		
		for(int i = 0; i <= M; i++)
			for(int j = 0; j <= M; j++){
				if(i == j)
					I[i][j] = alpha;
				else
					I[i][j] = 0;
			}
		
		Matrix A = new Matrix(a);
		Matrix B = new Matrix(b);
		Matrix Identity = new Matrix(I);
		
		//calculate S
		Matrix S = A.times(B).times(beta);
		S = S.plus(Identity);	
		int rank = S.rank();
		S = S.inverse();
		
		//set SumPhi(x)t
		for(int i = 0; i < n; i++){
			for(int j = 0; j <= M; j++){
				c[j][0] += Math.pow(x[i], j) * price[i];
			}
		}
		Matrix SumPhit = new Matrix(c);
		
		//set Phi(x)T*S
		Matrix PhiTS = B.times(S);
	
		
		//calculate mean
		Matrix mean = PhiTS.times(SumPhit).times(beta);

		double[][] meanprice = mean.getArray();
		
		//calculate the variance
		double variance =  1/beta + B.times(S).times(B.transpose()).get(0, 0);
		
		double[] MeanVariance = {meanprice[0][0], variance};
		
		return MeanVariance;
	}
}
