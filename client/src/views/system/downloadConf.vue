<template>
  <div>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px; margin-top: 30px">
      <el-table-column prop="type" label="类型" align="center"/>
      <el-table-column prop="currentVersion" label="当前版本" align="center"/>
      <el-table-column prop="systemSupport" label="系统支持" align="center"/>
      <el-table-column prop="fileSize" label="文件大小" align="center"/>
      <el-table-column prop="path" label="路径" align="center"/>
      <el-table-column prop="eidtTime" label="编辑时间" align="center"/>
      <el-table-column prop="operator" label="操作人" align="center"/>
      <el-table-column prop="operation" label="操作" align="center">
        <template slot-scope="scope">
          <el-button @click="dialogEditVisiable=true">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- dialog 编辑 -->
    <el-dialog :visible.sync="dialogEditVisiable" title="编辑" center>
      <el-form ref="ruleForm1" :model="ruleForm1" :rules="rules1">

        <el-form-item :label-width="ruleForm1.labelWidth" label="类型">
          <el-input v-model="ruleForm1.type" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="ruleForm1.labelWidth" label="当前版本" prop="currentVersion">
          <el-input v-model="ruleForm1.currentVersion" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="ruleForm1.labelWidth" label="系统支持" prop="systemSupport">
          <el-input v-model="ruleForm1.systemSupport" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="ruleForm1.labelWidth" label="安装包名称">
          <el-input v-model="ruleForm1.installationPackageName" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="ruleForm1.labelWidth" label="上传安装包">
          <el-upload
            :on-preview="handlePreview"
            :on-remove="handleRemote"
            :before-remove="beforeRemove"
            :limit="3"
            :on-exceed="handleExceed"
            :file-list="ruleForm1.fileList"
            class="upload-demo"
            action=""
            multiple
          >
            <el-button size="small" type="primary">点击上传</el-button>
            <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
          </el-upload>
        </el-form-item>

        <el-form-item>
          <el-button @click="dialogEditVisiable = false">取 消</el-button>
          <el-button type="primary" @click="submitRuleForm('ruleForm1')">保 存</el-button>
        </el-form-item>
      </el-form>

    </el-dialog>

  </div>
</template>

<script>

export default {
  data() {
    return {

      // tableData
      tableData: [{
        type: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        timeBegin: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
      }],

      // dialog1 编辑
      dialogEditVisiable: false,
      ruleForm1: {
        type: '',
        currentVersion: '',
        systemSupport: '',
        installationPackageName: '',
        labelWidth: '120px',
        optionsRole: [{
          label: '客服',
          value: 'customer'
        }],
        optionsStatus: [{
          label: '正常',
          value: 'normal'
        }, {
          label: '冻结',
          value: 'frozen'
        }],
        fileList: []
      },
      rules1: {
        currentVersion: [
          { required: true, message: '请输入当前版本号', trigger: 'blur' }
        ],
        systemSupport: [
          { required: true, message: '请输入系统支持', trigger: 'blur' }
        ]
      }

    }
  },
  methods: {
    handleRemove(file, fileList) {
    },
    handlePreview(file) {
    },
    handleExceed(files, fileList) {
      this.$message.warning(`当前限制选择3个文件, 本次选择了${files.length} 个文件, 共选择了 ${files.length + fileList.length} 个文件`)
    },
    beforeRemove(file, fileList) {
      return this.$confirm(`确定移除 ${file.name}?`)
    }
  }
}
</script>
