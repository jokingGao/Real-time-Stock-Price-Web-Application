  // written by: Wangzhe Chen
  // assisted by: Jinqin Gao
  // debugged by: Siyuan Zhong

import java.io.BufferedReader;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;

public class go {
	public int N;
	public double[] in;
	String name;
	public double[] weights;
	public int count;
	public go(int n, String name){
		N = n;
		in = new double[30000];
		this.name = name;
		this.count = 0;
		readfile();
	    
		
	}
	
	public void readfile(){
        String filename = 
        		"/Users/chenwangzhe/Downloads/" 
                + name + "_historical.csv";
	    
		try {
	        BufferedReader getinfo = new BufferedReader(new FileReader(filename));
	        String line = null;
	        //int count = 0;
	        while((line = getinfo.readLine()) != null/*&& count <= N+1*/){
	            String info[] = line.split(",");
	            in[count] = Double.parseDouble(info[6]);//price
	            count++;
	        }  
	        count--;
	        getinfo.close();
	    }
	     catch (Exception e) {e.printStackTrace();}
	}
	
	public void train(double er){
		double min = in[count],max = in[count];
		for(int i = 0; i < 100+N; i++){
			if(min > in[count-i]) min = in[count-i];
			if(max < in[count-i]) max = in[count-i];
		}
		double [][]trainset = new double[100][N];
		double []result = new double[100];
		//training sets
		for(int i = 0; i < 100; i++){
			for(int m = 0; m < N; m++){
	        	trainset[i][m] = (in[count-100-N+i + m]-min)/(max-min);        	
	        }
			result[i] = (in[count-100-N+i + N]-min)/(max-min);
        }	
	    neu hiddenNeuron1 = new neu(N);
	    neu hiddenNeuron2 = new neu(N);
	    neu hiddenNeuron3 = new neu(N);
	    neu outputNeuron = new neu(3);
	    
	    //Set random weights.
	    hiddenNeuron1.randomizeWeights();
	    hiddenNeuron2.randomizeWeights();
	    hiddenNeuron3.randomizeWeights();
	    outputNeuron.randomizeWeights();
	    
	    System.out.println("The initial weights are:" );
	    System.out.println("First hidden neuron: ");
	    for(int m = 0; m < N; m++){
	    	System.out.println(hiddenNeuron1.weights[m]);
	    }
	    System.out.println("Second hidden neuron: ");
	    for(int m = 0; m < N; m++){
	    	System.out.println(hiddenNeuron2.weights[m]);
	    }
	    System.out.println("Third hidden neuron: ");
	    for(int m = 0; m < N; m++){
	    	System.out.println(hiddenNeuron3.weights[m]);
	    }
	    System.out.println("Output neuron: "+outputNeuron.weights[0] +" " + outputNeuron.weights[1] );
	 
	    int count = 0;
	    double error = 0;
	    for (int p = 0; p < 1000000; p++) {
	        //count++;
	        for (int i = 0; i < 100; i++) { //i for each input.
	        	count++;  
	            //Forward propagation calculating outputs.
	            //Loading input i into each neuron.
	        	for(int u = 0; u < N; u++){
	        		hiddenNeuron1.inputs[u] = trainset[i][u];
	        		hiddenNeuron2.inputs[u] = trainset[i][u];
	        		hiddenNeuron3.inputs[u] = trainset[i][u];
	        	}	        		
	            
	            //Getting the output.
	            outputNeuron.inputs[0] = hiddenNeuron1.put();
	            outputNeuron.inputs[1] = hiddenNeuron2.put();
	            outputNeuron.inputs[2] = hiddenNeuron3.put();
	            
	            
	            //Adjusts the the output neuron (weight)from it's error (derivative of the calculated sigmoid
	            //output * the difference of the result and the derivative of the calculated sigmoid function)
	            outputNeuron.error = outputNeuron.derivative(outputNeuron.put()) * (result[i] - outputNeuron.put());
	            outputNeuron.adjustWeights();
	            error = result[i] - outputNeuron.put();
	            if ( i == 0 && p == 0) {
	                System.out.println("\nThe first-batch error is " + error);
	            }
	            if (Math.abs(error) < er) {
	                break;
	            }
	            //Adjusts the hidden neurons (weights) from their errors (derivative of the calculated sigmoid output * output error * output weight).
	            hiddenNeuron1.error = hiddenNeuron1.derivative(hiddenNeuron1.put()) * outputNeuron.error * outputNeuron.weights[0];
	            hiddenNeuron2.error = hiddenNeuron2.derivative(hiddenNeuron2.put()) * outputNeuron.error * outputNeuron.weights[1];
	            hiddenNeuron3.error = hiddenNeuron3.derivative(hiddenNeuron3.put()) * outputNeuron.error * outputNeuron.weights[2];
	            
	            hiddenNeuron1.adjustWeights();
	            hiddenNeuron2.adjustWeights();
	            hiddenNeuron3.adjustWeights();
	            
	        }
	        if (Math.abs(error) < er) {
	            break;
	        }
	    }
	    System.out.println("\nThe final weights are:");
	    System.out.println("First hidden neuron: ");
	    for(int m = 0; m < N; m++){
	    	System.out.println(hiddenNeuron1.weights[m]);
	    }
	    System.out.println("Second hidden neuron: ");
	    for(int m = 0; m < N; m++){
	    	System.out.println(hiddenNeuron2.weights[m]);
	    }
	    System.out.println("Third hidden neuron: ");
	    for(int m = 0; m < N; m++){
	    	System.out.println(hiddenNeuron3.weights[m]);
	    }
	    System.out.println("Output neuron: "+outputNeuron.weights[0] +" " + outputNeuron.weights[1] );
	    System.out.println("\nThe final error is " + error /*+ " " + (outputNeuron.put()*(max-min)+min)*/);
	    System.out.println("The total number of batches run through in the training is: " + count);
	    
	    FileWriter writer;
        try {
            writer = new FileWriter("/Users/chenwangzhe/Documents/workspace/Predict_neu/src/"+name+"train.txt",false);
            for(int m = 0; m < N; m++){
    	    	writer.write(Double.toString(hiddenNeuron1.weights[m])+"\n");
    	    	writer.flush();
    	    }
    	    for(int m = 0; m < N; m++){
    	    	writer.write(Double.toString(hiddenNeuron2.weights[m])+"\n");
    	    	writer.flush();
    	    }
    	    for(int m = 0; m < N; m++){
    	    	writer.write(Double.toString(hiddenNeuron3.weights[m])+"\n");
    	    	writer.flush();
    	    }
            writer.write(Double.toString(outputNeuron.weights[0])+"\n");
            writer.write(Double.toString(outputNeuron.weights[1]));
            writer.flush();
            writer.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
	}
	
	public double predict(){
		weights = new double[3*N+2];
		String filename = 
        		"/Users/chenwangzhe/Documents/workspace/Predict_neu/src/"+name+"train.txt"; 
	    
		try {
	        BufferedReader getinfo = new BufferedReader(new FileReader(filename));
	        String line = null;
	        int count = 0;
	        while((line = getinfo.readLine()) != null){
	            weights[count] = Double.parseDouble(line);//price
	            count++;
	        }  
	        getinfo.close();
	    }
	     catch (Exception e) {e.printStackTrace();}
		
		//GET INPUT
        double []input = new double [30000];
		String filename1 = 
        		"/Users/chenwangzhe/Downloads/" 
                + name + "_historical.csv";
	    
		try {
	        BufferedReader getinfo = new BufferedReader(new FileReader(filename1));
	        String line = null;
	        int count = 0;
	        while((line = getinfo.readLine()) != null /*&& count < N*/){
	            String info[] = line.split(",");
	            input[count] = Double.parseDouble(info[6]);//price
	            count++;
	        }  
	        getinfo.close();
	    } catch (Exception e) {e.printStackTrace();}
		
		double min = input[count],max = input[count];
		for(int i = 0; i < N; i++){
			if(min > input[count-i]) min = input[count-i];
			if(max < input[count-i]) max = input[count-i];
		}
		
		neu hiddenNeuron1 = new neu(N);
	    neu hiddenNeuron2 = new neu(N);
	    neu hiddenNeuron3 = new neu(N);
	    neu outputNeuron = new neu(3);
	    for(int u = 0; u < N; u++){
    		hiddenNeuron1.inputs[u] = (input[count-N+1+u]-min)/(max-min);
    		hiddenNeuron2.inputs[u] = (input[count-N+1+u]-min)/(max-min);
    		hiddenNeuron3.inputs[u] = (input[count-N+1+u]-min)/(max-min);
    	}	
	    
	    //Set weights
	    int p = 0;
	    for( p = 0; p < 3 * N + 2; p++){
	    	if(p < N){
	    		int c = p % N;
    		    hiddenNeuron1.weights[c] = weights[p];
    		}
	    	else if(p < 2 * N){
	    		int c = p % N;
    		    hiddenNeuron2.weights[c] = weights[p];
    		}
	    	else if(p < 3 * N){
	    		int c = p % N;
    		    hiddenNeuron3.weights[c] = weights[p];
    		}
	    	else if(p < 4 * N){
	    		int c = p % N;
    		    outputNeuron.weights[c] = weights[p];
    		}
    	}
        
        //Getting the output.
        outputNeuron.inputs[0] = hiddenNeuron1.put();
        outputNeuron.inputs[1] = hiddenNeuron2.put();
        outputNeuron.inputs[2] = hiddenNeuron3.put();
        
        //Getting the prediction
        return (outputNeuron.put()*(max-min)+min);
	}
	
}
    
    
