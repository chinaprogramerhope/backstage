<template>
  <div>

    <el-form :inline="true" :model="form1" align="left" style="margin-left: 30px; margin-top: 30px" label-position="right" label-width="100px">

      <el-form-item label="渠道:">
        <el-select v-model="form1.selectChannelName">
          <el-option
            v-for="item in form1.optionsChannelName"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button v-model="tips" type="primary" size="small" @click="dialogFormAddVisible = true">添加游戏版本</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="online" label="渠道号" align="center"/>
      <el-table-column min-width="10%" prop="id" label="游戏" align="center"/>
      <el-table-column min-width="10%" prop="user_email" label="tag" align="center"/>
      <el-table-column min-width="10%" prop="userIDCardName" label="最新版本号" align="center"/>
      <el-table-column min-width="10%" prop="upLine" label="过期版本号" align="center"/>
      <el-table-column min-width="10%" prop="downLineNum" label="状态" align="center"/>
      <el-table-column min-width="10%" prop="isBlack" label="操作" align="center">
        <template slot-scope="scope">
          <div v-if="1">
            <el-tag size="small" type="success" @click="xx">启用</el-tag>
          </div>
          <div v-else>
            <el-tag size="small" type="danger" @click="xx">禁用</el-tag>
          </div>
        </template>
      </el-table-column>

    </el-table>

    <!-- dialogAdd 添加游戏版本 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="添加游戏版本">
      <el-form :model="dialogFormAdd">

        <el-form-item
          :label-width="dialogLabelWidth"
          label="最新版本号:"
          prop="lastestVersion"
        >
          <el-input v-model="dialogFormAdd.lastestVersion" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="最低版本号:"
          prop="lowestVersion"
        >
          <el-input v-model="dialogFormAdd.lowestVersion" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="下载url:"
          prop="downloadUrl"
        >
          <el-input v-model="dialogFormAdd.downloadUrl" autocomplete="off"/>
        </el-form-item>

        <el-form-item
          :label-width="dialogLabelWidth"
          label="状态"
          prop="status"
        >
          <el-radio v-model="dialogFormAdd.radioStatus" label="1">已上线</el-radio>
          <el-radio v-model="dialogFormAdd.radioStatus" label="2">等待上线</el-radio>
        </el-form-item>

        <el-form-item align="center">
          <el-button @click="dialogFormAddVisible = false">取 消</el-button>
          <el-button type="primary" @click="handleAdd()">确 定</el-button>
        </el-form-item>

      </el-form>
    </el-dialog>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectChannelName: -1,
        optionsChannelName: [{
          label: '全部',
          value: -1
        }, {
          label: '发哥游戏Ios',
          value: 1
        }]

      },

      dialogLabelWidth: '200px',
      dialogFormAddVisible: false,

      dialogFormAdd: {
        lastestVersion: '',
        lowestVersion: '',
        downloadUrl: '',
        radioStatus: '2'
      }
    }
  },

  created() {

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
