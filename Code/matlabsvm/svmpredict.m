
data_1=importdata('google_historical.csv',',');
data_2=importdata('yahoo_historical.csv',',');
data_3=importdata('facebook_historical.csv',',');
data_4=importdata('apple_historical.csv',',');
data_5=importdata('microsoft_historical.csv',',');
data_6=importdata('nvidia_historical.csv',',');
data_7=importdata('amazon_historical.csv',',');
data_8=importdata('tesla_historical.csv',',');
data_9=importdata('sony_historical.csv',',');
data_10=importdata('alibaba_historical.csv',',');

xx = 1:10;
xx=xx';
predict=[];
for n=1:10
        eval(['y','=','data_',num2str(n),'.data(1:10,4)',';']);
        yy=flipud(y);
        model = libsvmtrain(yy,xx,'-s 3 -t 2 -c 2.2 -g 2.8 -p 0.001');
        testx = 11;
        [ptesty] = libsvmpredict(1,testx,model);
        lastdate_price = yy(10);
        predict=[predict;lastdate_price,ptesty];
end
% xx = 1:10;
% xx=xx';
% y=data_1.data(1:10,4);
% yy=flipud(y);
% model = libsvmtrain(yy,xx,'-s 3 -t 2 -c 2.2 -g 2.8 -p 0.01');
% testx = 11;
% [ptesty] = libsvmpredict(4,testx,model);
% ptesty