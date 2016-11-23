namespace DirectAPI_Csharp_Sample
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.btProcess = new System.Windows.Forms.Button();
            this.txtJSONRequest = new System.Windows.Forms.TextBox();
            this.txtJSONResponse = new System.Windows.Forms.TextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.SuspendLayout();
            // 
            // btProcess
            // 
            this.btProcess.Location = new System.Drawing.Point(102, 111);
            this.btProcess.Name = "btProcess";
            this.btProcess.Size = new System.Drawing.Size(89, 43);
            this.btProcess.TabIndex = 1;
            this.btProcess.Text = "Process";
            this.btProcess.UseVisualStyleBackColor = true;
            this.btProcess.Click += new System.EventHandler(this.btProcess_Click);
            // 
            // txtJSONRequest
            // 
            this.txtJSONRequest.Location = new System.Drawing.Point(285, 36);
            this.txtJSONRequest.Multiline = true;
            this.txtJSONRequest.Name = "txtJSONRequest";
            this.txtJSONRequest.ScrollBars = System.Windows.Forms.ScrollBars.Vertical;
            this.txtJSONRequest.Size = new System.Drawing.Size(339, 375);
            this.txtJSONRequest.TabIndex = 2;
            // 
            // txtJSONResponse
            // 
            this.txtJSONResponse.Location = new System.Drawing.Point(671, 36);
            this.txtJSONResponse.Multiline = true;
            this.txtJSONResponse.Name = "txtJSONResponse";
            this.txtJSONResponse.ScrollBars = System.Windows.Forms.ScrollBars.Vertical;
            this.txtJSONResponse.Size = new System.Drawing.Size(339, 375);
            this.txtJSONResponse.TabIndex = 3;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(281, 13);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(70, 20);
            this.label1.TabIndex = 4;
            this.label1.Text = "Request";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(667, 13);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(82, 20);
            this.label2.TabIndex = 5;
            this.label2.Text = "Response";
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(9F, 20F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1117, 423);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.txtJSONResponse);
            this.Controls.Add(this.txtJSONRequest);
            this.Controls.Add(this.btProcess);
            this.Name = "Form1";
            this.Text = "Direct API C# Sample";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button btProcess;
        private System.Windows.Forms.TextBox txtJSONRequest;
        private System.Windows.Forms.TextBox txtJSONResponse;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
    }
}

