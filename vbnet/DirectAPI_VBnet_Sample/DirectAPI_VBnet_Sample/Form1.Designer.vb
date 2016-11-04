<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Main
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.txtMerchantId = New System.Windows.Forms.TextBox()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.txtMerchantKey = New System.Windows.Forms.TextBox()
        Me.Label3 = New System.Windows.Forms.Label()
        Me.txtClientSecret = New System.Windows.Forms.TextBox()
        Me.Label4 = New System.Windows.Forms.Label()
        Me.txtClientId = New System.Windows.Forms.TextBox()
        Me.Label5 = New System.Windows.Forms.Label()
        Me.txtJSONrequest = New System.Windows.Forms.TextBox()
        Me.btProcess = New System.Windows.Forms.Button()
        Me.btLoad = New System.Windows.Forms.Button()
        Me.Label6 = New System.Windows.Forms.Label()
        Me.txtJSONResponse = New System.Windows.Forms.TextBox()
        Me.SuspendLayout()
        '
        'txtMerchantId
        '
        Me.txtMerchantId.Location = New System.Drawing.Point(38, 51)
        Me.txtMerchantId.Name = "txtMerchantId"
        Me.txtMerchantId.Size = New System.Drawing.Size(257, 20)
        Me.txtMerchantId.TabIndex = 0
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Location = New System.Drawing.Point(35, 35)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(66, 13)
        Me.Label1.TabIndex = 1
        Me.Label1.Text = "Merchant ID"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Location = New System.Drawing.Point(35, 80)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(73, 13)
        Me.Label2.TabIndex = 3
        Me.Label2.Text = "Merchant Key"
        '
        'txtMerchantKey
        '
        Me.txtMerchantKey.Location = New System.Drawing.Point(38, 96)
        Me.txtMerchantKey.Name = "txtMerchantKey"
        Me.txtMerchantKey.Size = New System.Drawing.Size(257, 20)
        Me.txtMerchantKey.TabIndex = 2
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Location = New System.Drawing.Point(35, 205)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(67, 13)
        Me.Label3.TabIndex = 7
        Me.Label3.Text = "Client Secret"
        '
        'txtClientSecret
        '
        Me.txtClientSecret.Location = New System.Drawing.Point(38, 221)
        Me.txtClientSecret.Name = "txtClientSecret"
        Me.txtClientSecret.Size = New System.Drawing.Size(257, 20)
        Me.txtClientSecret.TabIndex = 6
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Location = New System.Drawing.Point(35, 160)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(47, 13)
        Me.Label4.TabIndex = 5
        Me.Label4.Text = "Client ID"
        '
        'txtClientId
        '
        Me.txtClientId.Location = New System.Drawing.Point(38, 176)
        Me.txtClientId.Name = "txtClientId"
        Me.txtClientId.Size = New System.Drawing.Size(257, 20)
        Me.txtClientId.TabIndex = 4
        '
        'Label5
        '
        Me.Label5.AutoSize = True
        Me.Label5.Location = New System.Drawing.Point(338, 35)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(78, 13)
        Me.Label5.TabIndex = 9
        Me.Label5.Text = "JSON Request"
        '
        'txtJSONrequest
        '
        Me.txtJSONrequest.Location = New System.Drawing.Point(341, 51)
        Me.txtJSONrequest.Multiline = True
        Me.txtJSONrequest.Name = "txtJSONrequest"
        Me.txtJSONrequest.ScrollBars = System.Windows.Forms.ScrollBars.Vertical
        Me.txtJSONrequest.Size = New System.Drawing.Size(263, 350)
        Me.txtJSONrequest.TabIndex = 8
        '
        'btProcess
        '
        Me.btProcess.Location = New System.Drawing.Point(220, 275)
        Me.btProcess.Name = "btProcess"
        Me.btProcess.Size = New System.Drawing.Size(75, 23)
        Me.btProcess.TabIndex = 10
        Me.btProcess.Text = "Process"
        Me.btProcess.UseVisualStyleBackColor = True
        '
        'btLoad
        '
        Me.btLoad.Location = New System.Drawing.Point(38, 275)
        Me.btLoad.Name = "btLoad"
        Me.btLoad.Size = New System.Drawing.Size(125, 23)
        Me.btLoad.TabIndex = 11
        Me.btLoad.Text = "Load Test Credentials"
        Me.btLoad.UseVisualStyleBackColor = True
        '
        'Label6
        '
        Me.Label6.AutoSize = True
        Me.Label6.Location = New System.Drawing.Point(637, 35)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(86, 13)
        Me.Label6.TabIndex = 13
        Me.Label6.Text = "JSON Response"
        '
        'txtJSONResponse
        '
        Me.txtJSONResponse.Location = New System.Drawing.Point(640, 51)
        Me.txtJSONResponse.Multiline = True
        Me.txtJSONResponse.Name = "txtJSONResponse"
        Me.txtJSONResponse.ScrollBars = System.Windows.Forms.ScrollBars.Vertical
        Me.txtJSONResponse.Size = New System.Drawing.Size(263, 350)
        Me.txtJSONResponse.TabIndex = 12
        '
        'Main
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(915, 413)
        Me.Controls.Add(Me.Label6)
        Me.Controls.Add(Me.txtJSONResponse)
        Me.Controls.Add(Me.btLoad)
        Me.Controls.Add(Me.btProcess)
        Me.Controls.Add(Me.Label5)
        Me.Controls.Add(Me.txtJSONrequest)
        Me.Controls.Add(Me.Label3)
        Me.Controls.Add(Me.txtClientSecret)
        Me.Controls.Add(Me.Label4)
        Me.Controls.Add(Me.txtClientId)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.txtMerchantKey)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.txtMerchantId)
        Me.Name = "Main"
        Me.Text = "Direct API VBnet Sample"
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub

    Friend WithEvents txtMerchantId As TextBox
    Friend WithEvents Label1 As Label
    Friend WithEvents Label2 As Label
    Friend WithEvents txtMerchantKey As TextBox
    Friend WithEvents Label3 As Label
    Friend WithEvents txtClientSecret As TextBox
    Friend WithEvents Label4 As Label
    Friend WithEvents txtClientId As TextBox
    Friend WithEvents Label5 As Label
    Friend WithEvents txtJSONrequest As TextBox
    Friend WithEvents btProcess As Button
    Friend WithEvents btLoad As Button
    Friend WithEvents Label6 As Label
    Friend WithEvents txtJSONResponse As TextBox
End Class
