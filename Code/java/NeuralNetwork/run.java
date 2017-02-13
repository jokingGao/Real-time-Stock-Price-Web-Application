  // written by: Wangzhe Chen
  // assisted by: Jinqin Gao
  // debugged by: Siyuan Zhong

import java.io.FileWriter;
import java.io.IOException;
import java.util.Scanner;

public class run {

	public static void main(String[] args) {
		String name = "facebook";
		Scanner in = new Scanner(System.in);
		System.out.print("Please choose the train(1) or test(2)\n");
		int N = in.nextInt();
		if(N==1){
			go Predict = new go(7,name);
			Predict.train(0.0001);
		}
        if(N==2){
        	for(int i = 0; i < 10; i++){
    		go Predict = new go(7,name);	
    		double prediction;   		
    			System.out.println(prediction=Predict.predict());
    			FileWriter writer;
    	        try {
    	            writer = new FileWriter("/Users/chenwangzhe/Downloads/"+name+"_historical.csv",true);
    	    	    writer.write("\n"+"0" + "," + "0" + "," + "0" + "," + "0" + "," + "0"+ "," + "0"+ "," + Double.toString(prediction));
    	    	    writer.flush();
    	    	    } 
    	        catch (IOException e) {e.printStackTrace();}
    	        }
        }		
		}	
	}
